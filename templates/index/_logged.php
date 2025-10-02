<form action="sg.php" method="post" enctype="multipart/form-data">
  <div style="width: 100%;height: 50vh;padding-top: 70px;padding-left: 318px;">
  <div class="form-floating">
    <textarea name="text" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px;width: 700px;"></textarea>
    <label for="floatingTextarea2">Comments</label>
  </div>
  <div class="mb-3" style="margin-top: 4px;">
    <input name="file" type="file" class="form-control" aria-label="file example" style="width: 700px;" required>
    <div class="invalid-feedback">Example invalid form file feedback</div>
  </div>
  <button style="width: 700px;" type="submit" class="btn btn-primary">Post</button>
</div>
</form>