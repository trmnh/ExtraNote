<?php
$note_file = '/Applications/XAMPP/htdocs/LPB/prj-extranoteOG/notes/' . $_GET['file'];
$confirm_delete_link = 'index.php?page=delete_note&file=' . urlencode($note_file);
?>
<div class="row">
    <div class="col-12 text-center">  
        <div class="alert alert-warning">
            Souhaitez-vous vraiment supprimer cette note ? <br> 
            <strong><?php echo htmlspecialchars($note_name); ?></strong>
        </div>            
        <div>
            <a href="index.php?page=view_note&file=<?php echo urlencode($note_file); ?>" class="btn btn-outline-success">Annuler</a>
            <a href="<?php echo $confirm_delete_link; ?>" class="btn btn-outline-danger">Confirmer</a>
        </div>
    </div>                     
</div>
