<div class="row">
    <div class="col-12">                    
        <h1 class="mb-3 appMainColor appPageTitle">Nouvelle note</h1>   
    </div>
</div> 
<div class="row">
    <div class="col-12">                    
        <form id="form_add_note" action="index.php?page=addnote" method="post"> 
            <div class="mb-3 form-group">
                <label for="title_note" class="form-label appLabel">Titre</label>
                <input type="text" class="form-control" name="title_note" id="title_note" placeholder="Titre" required>
            </div>
            <div class="mb-3 form-group">
                <label for="type_note" class="form-label appLabel">Type</label>
                <select name="type_note" id="type_note" class="form-control" required>
                    <option value="note">Note textuelle</option>
                    <option value="code">Code Source</option>
                    <option value="lien">Lien / URL</option>
                </select>
            </div>
            <div class="mb-3 form-group">                                                   
                <input class="form-check-input" type="checkbox" value="1" id="favori_note" name="favori_note">
                <label class="form-check-label" for="favori_note">Ajouter aux favoris</label>
            </div>    
            <div class="mb-3 form-group">
                <label for="content_note" class="form-label appLabel">Contenu</label>
                <textarea name="content_note" id="content_note" class="form-control" placeholder="Contenu" rows="10" required></textarea>
            </div>
            <input type="hidden" name="action" value="addnote"> <!-- Champ caché pour l'action -->
            <button type="submit" class="btn btn-outline-success">Ajouter</button>
            <a href="index.php" class="btn btn-outline-danger">Annuler</a>
        </form>                
    </div>
</div>
