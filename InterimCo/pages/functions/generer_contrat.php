<?php
function generer_contrat($contrat_info, $prestations)
{
    ob_start(); // Start output buffering
    ?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Détails du Contrat</title>
    </head>
    <body>
    <h1>Détails du Contrat</h1>
    <h2>Contrat de Services de Plomberie</h2>
    <p>Le Prestataire: InterimCo</p>
    <?php
    // Assuming $_SESSION['authenticated_user'] contains user info
    $user_info = $_SESSION['authenticated_user'];
    echo "<p>Le Client: {$user_info['nom']}</p>";
    ?>
    <p>Objet du contrat:</p>
    <p>Le Prestataire s'engage à fournir les services au Client conformément aux prestations et aux conditions définies dans le contrat principal.</p>
    <h3>Prestations:</h3>
    <ul>
        <?php
        foreach ($prestations as $prestation) {
            echo "<li>{$prestation['description']}</li>";
            echo "<ul>";
            echo "<li>Date de Début: {$prestation['date_debut']}</li>";
            echo "<li>Date de Fin: {$prestation['date_fin']}</li>";
            echo "</ul>";
        }
        ?>
    </ul>
    <p>Prix Total: <?php echo $contrat_info['prix']; ?> DT (Dinars Tunisiens)</p>
    <h3>Engagements du Prestataire:</h3>
    <ul>
        <li>Fournir des services de qualité conforme aux normes de l'industrie.</li>
        <li>Respecter les délais convenus pour chaque prestation.</li>
    </ul>
    <h3>Engagements du Client:</h3>
    <ul>
        <li>Faciliter l'accès aux locaux pour l'exécution des travaux.</li>
        <li>Payer les montants dus selon les termes convenus.</li>
    </ul>
    <p>Durée du contrat:</p>
    <p>Ce contrat prend effet à partir de la date de signature et reste valide jusqu'à l'achèvement des prestations mentionnées ou jusqu'à résiliation par consentement mutuel ou pour motif valable.</p>
    <p>Dispositions générales:</p>
    <ul>
        <li>Toute modification ou ajout aux prestations convenues devra faire l'objet d'un avenant écrit signé par les deux parties.</li>
        <li>En cas de litige, les parties s'engagent à rechercher une solution amiable avant d'entamer toute procédure juridique.</li>
    </ul>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script>
        // Function to download PDF
        function downloadPDF() {
            html2canvas(document.body).then(function(canvas) {
                var imgData = canvas.toDataURL('image/png');
                var pdf = new jsPDF();
                pdf.addImage(imgData, 'PNG', 0, 0, pdf.internal.pageSize.getWidth(), pdf.internal.pageSize.getHeight());
                pdf.save('contrat.pdf');
            });
        }
        // Call the downloadPDF function after the page has loaded
        window.onload = downloadPDF;
    </script>
    </body>
    </html>

    <?php
    $html_content = ob_get_clean(); // Get the generated HTML content and clean the output buffer

    return $html_content;
}
?>