<!-- search_form.php -->

<div class="row">
    <div class="col-md-3">
        <form id="form_sort_note" method="post">
            <label for="sort_note" class="label_sort_note">Trier par</label>
            <select name="sort_note" id="sort_note" class="select_sort_note">
                <option value="date" selected>Date</option>
                <option value="title">Titre</option>
                <option value="type">Type</option>
                <option value="favoris">Favoris</option>
            </select>
            <select name="sort_order" id="sort_order" class="select_sort_order">
                <option value="asc">Asc</option>
                <option value="desc" selected>Desc</option>
            </select>
            <!--<button type="submit" class="btn btn-outline-success">Trier</button>-->
        </form>
    </div>
    <div class="col-md-9">
        <div class="input_wrapper float-end">
            <form id="form_search_note" method="post">
                <input type="hidden" name="action" value="search">
                <input type="text" name="search_term" id="search_term" class="input_search_note" placeholder="Rechercher une note">
                <button type="submit" class="btn_submit_search" title="Soumettre la recherche">&rarr;</button>
            </form>
        </div>
    </div>
</div>
