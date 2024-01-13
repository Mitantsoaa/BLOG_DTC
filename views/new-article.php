<form method="POST" action="" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="titre" class="form-label">Titre</label>
    <input type="text" class="form-control" id="titre" name="titre">
  </div>
  <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control" id="description" name="description"></textarea>
  </div>
  <div class="mb-3">
    <input type="file" class="form-file-input" id="image" name="image">
  </div>
  <button type="submit" class="btn btn-primary" name="form-submitted">Submit</button>
</form>