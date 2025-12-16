<?php
include 'inc/header.php';

// header tags toevoegen
echo '<div class="head">';
    echo '<p>Nieuwe gebruiker</p>';
echo '</div>'; // afsluiten div

// voor gridopmaak alvast de main-content
echo '<main class="main-content">';
    // Begin FORM
echo '<div id="frmDetail">';
?>

<div>
    <form action="dataverwerken.php" method="POST" class="frmDetail">
        <input type="hidden" name="action" value="InsertGebruiker">

        <label for="finlognaam">Inlognaam:</label>
        <input type="text" name="inlognaam" id="finlognaam" placeholder="Inlognaam gebruiker..." required>
        <small id="inlognaamFeedback" style="display: block;"></small>

        <label for="fwachtwoord">Wachtwoord:</label>
        <input type="password" name="wachtwoord" id="fwachtwoord" placeholder="Wachtwoord..." required>

        <label for="frol">Rol:</label>
        <select name="rol_id" id="frol" required>
            <option value="">-- kies rol --</option>
            <option value="1">Beheerder</option>
            <option value="2">Administratie</option>
            <option value="3">Planner</option>
            <option value="4">Klantrelaties</option>
        </select>

        <div class="submitbtn">
            <input type="submit" name="submit" value="bewaren..." class="btnDetailSubmit">
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('finlognaam');
    const feedback = document.getElementById('inlognaamFeedback');
    let timeout = null;

    input.addEventListener('input', function () {
        const waarde = input.value.trim();

        // leeg veld → feedback wissen
        if (waarde.length === 0) {
            feedback.textContent = 'Veld mag niet leeg zijn';
            feedback.style.color = 'red';
            return
        }

        // debounce (niet bij elke letter meteen)
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            fetch('check_gebruiker.php?inlognaam=' + encodeURIComponent(waarde))
                .then(response => response.json())
                .then(data => {
                    if (data.bestaat) {
                        feedback.textContent = 'Deze inlognaam bestaat al';
                        feedback.style.color = 'red';
                    } else {
                        feedback.textContent = 'Inlognaam is beschikbaar';
                        feedback.style.color = 'green';
                    }
                })
                .catch(() => {
                    feedback.textContent = 'Fout bij controleren';
                    feedback.style.color = 'red';
                });
        }, 300);
    });
});

</script>

<?php
echo '</div>'; // frmDetail afsluiten
include 'inc/footer.php';
?>
