<x-layouts::app :title="__('Add Resource')">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <div class="container mt-4">
      @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
      @endif
    <div class="card">
      <div class="card-header text-center font-weight-bold">
        Add Resource
      </div>
      <div class="card-body">
        <form name="add-resource-form" id="add-resource-form" method="post" action="{{url('store')}}">

        @csrf

          <div class="form-group">
            <label for="exampleInputEmail1">URL</label>
            <input type="text" id="url" name="url" class="form-control" required="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Title</label>
            <input type="text" id="title" name="title" class="form-control" required="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Banner</label>
            <input type="text" id="banner" name="banner" class="form-control">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Authors</label>
            <input type="text" id="authors" name="authors" class="form-control">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Summary</label>
            <textarea id="summary" name="summary" class="form-control" required=""></textarea>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Categories</label>
            <input type="text" id="categories" name="categories" class="form-control" required="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Topics</label>
            <input type="text" id="topics" name="topics" class="form-control" required="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Activities</label>
            <input type="text" id="activities" name="activities" class="form-control" required="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Opportunities</label>
            <input type="text" id="opportunities" name="opportunities" class="form-control" required="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Regions</label>
            <input type="text" id="regions" name="regions" class="form-control" required="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Language</label>
            <input type="text" id="language" name="language" class="form-control" required="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Content</label>
            <textarea id="content" name="content" class="form-control"></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>  
</x-layouts::app>