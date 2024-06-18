<div class="row">
    <div class="col-12">                    
        <h1 class="mb-3 appMainColor appPageTitle">Modifier la note</h1>   
    </div>
</div> 
<div class="row">
    <div class="col-12">                    
        <form id="form_edit_note" action="index.php?page=edit_note&file=<?php echo urlencode($note['filename']); ?>" method="post">
            <input type="hidden" name="note_id" value="<?php echo htmlspecialchars($note['filename']); ?>">
            <div class="mb-3 form-group">
                <label for="title" class="form-label appLabel">Titre</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="Titre" value="<?php echo htmlspecialchars($note['title']); ?>" required>
            </div>
            <div class="mb-3 form-group">
                <label for="type" class="form-label appLabel">Type</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="note" <?php echo ($note['type'] === 'note') ? 'selected' : ''; ?>>Note textuelle</option>
                    <option value="code" <?php echo ($note['type'] === 'code') ? 'selected' : ''; ?>>Code Source</option>
                    <option value="lien" <?php echo ($note['type'] === 'lien') ? 'selected' : ''; ?>>Lien / URL</option>
                </select>
            </div>
            <div class="mb-3 form-group">                                                   
                <input class="form-check-input" type="checkbox" value="1" id="favoris" name="favoris" <?php echo ($note['favoris'] === 1) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="favoris">Ajouter aux favoris</label>
            </div>    
            <div class="mb-3 form-group">
                <label for="content" class="form-label appLabel" id="label_content">Contenu</label>
                <textarea name="content" id="content" class="form-control" placeholder="Contenu" rows="10" required><?php echo htmlspecialchars($note['content']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-outline-success">Enregistrer</button>
            <a href="index.php" class="btn btn-outline-danger">Annuler</a>
        </form>                
    </div>
</div>
