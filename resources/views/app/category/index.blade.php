<label style='font-size: 18px;' id='labelLink' for='exampleFormControlInput1'>Select some categories do you want to link/deslink that code</label>
<select name="code_categories_id" multiple required class="custom-select" id="code_category_id">
    @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->description }}</option>
    @endforeach
</select>
