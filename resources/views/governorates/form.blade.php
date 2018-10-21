<div class="form-group">
    <label for="name">Name</label>
    {!! Form::text('name',$model->name,[
        'class' => 'form-control'
    ]) !!}
</div>
<div class="form-group">
    <button class="btn btn-primary" type="submit">Submit</button>
</div>