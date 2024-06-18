<?php
// Vérifier si les détails de la note sont disponibles
if (isset($note_details)) {
    $note_title = htmlspecialchars($note_details['title']);
    $note_date = htmlspecialchars($note_details['date']);
    $note_content = htmlspecialchars($note_details['content']);
    $note_type = htmlspecialchars($note_details['type']);
    $note_filename = htmlspecialchars($note_details['filename']);
    $note_favoris = $note_details['favoris'] ? '<img src="assets/img/favorite.png" alt="favoris">' : '';

    // Déterminer comment afficher le contenu en fonction du type de la note
    if ($note_type === 'code') {
        $note_content_display = '<pre><code>' . $note_content . '</code></pre>';
    } else {
        $note_content_display = nl2br($note_content);
    }

    echo '
    <div class="row">
        <div class="col-4 appViewNote">
            <h1 class="mb-3 appMainColor appPageTitle">' . $note_title . ' ' . $note_favoris . '</h1>
            <hr>
            <h6 class="mb-3 appMainColor"><span class="badge">' . $note_type . '</span></h6>
            <h6 class="mb-3 appMainColor"><span class="">' . $note_date . '</span></h6>
            <a href="index.php?page=edit_note&file=' . $note_filename . '" class="btn btn-outline-success btn-sm btn-note-edit" title="Modifier">Modifier</a>
            <a href="index.php?page=confirm_delete&file=' . $note_filename . '" class="btn btn-outline-danger btn-sm btn-note-delete" title="Supprimer">Supprimer</a>
        </div>
        <div class="col-1"></div>
        <div class="col-7 appViewNote">
            <div>
                ' . $note_content_display . '
            </div>
        </div>
    </div>';
} else {
    echo '<p>Les détails de la note ne sont pas disponibles.</p>';
}
?>
