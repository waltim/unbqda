@extends('app.layouts.basico')

@section('titulo', $titulo)

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h1 class="unselectable">Codes and Categories</h1>
        </div>

        <div class="text-right" style="padding-right: 5%">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button"
                    onclick="location.href = '{{ route('project.show', ['project' => $project->id]) }}';"
                    class="btn btn-outline-primary">List Interviews</button>
                <button type="button" data-toggle="modal" class="btn btn-outline-primary" onclick="FreshCategoriesOptions()"
                    data-target=".bd-example-modal-lg">New Category</button>
            </div>
        </div>
    </div>

    <div style="width: 95%; margin: auto;">
        <div class="row">
            <div class="col-md-6 text-center">
                <div class="child-sections">
                    <h1 class=".sub-titulos">Codes &#8611; Category</h1>
                </div>
                <div id="codes-table" style="width: 90%; margin-left: auto; margin-right: auto;">
                    <table id='codeTable' class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Memo</th>
                                <th scope="col">Quote</th>
                                <th scope="col">Categories linked</th>
                                <th scope="col">Category actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($codes as $code)
                                <tr>
                                    <th scope="row">{{ $code->id }}</th>
                                    <td>{{ $code->description }}</td>
                                    <td>
                                        <a tabindex="0" role="button" data-toggle="popover" data-trigger="focus"
                                            class="btn btn-outline-success popover-click" title="{{ $code->description }}"
                                            data-content="{{ $code->memo }}">show
                                            memoing</a>
                                    </td>
                                    <td>
                                        @foreach ($code->quotes as $quote)
                                            <a tabindex="0" role="button" data-toggle="popover" data-trigger="focus"
                                                class="btn btn-outline-secondary popover-click"
                                                title="Quote: {{ $quote->id }}"
                                                data-content="{{ $quote->description }}">{{ $quote->id }}</a>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($code->categories as $category)
                                            <a tabindex="0" role="button" data-toggle="popover" class="btn popover-click"
                                                style="background-color: {{ $category->color }}; color: white;" data-trigger="focus"
                                                title="{{ $category->description }}"
                                                data-content="{{ $category->memo }}">{{ $category->id }}</a>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#exampleModalCenter"
                                                onclick="getIdcode({{ $code->id }},'{{ $code->description }}','link')">
                                                Link
                                            </button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#exampleModalCenter"
                                                onclick="getIdcode({{ $code->id }},'{{ $code->description }}','remove')">
                                                Remove
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $codes->withQueryString()->links() }}
                    {{ $codes->total() > 0 ? $codes->total() . ' - registro(s) encontrado(s).' : 'nenhum registro encontrado.' }}
                </div>
            </div>
            <div class="col-md-6 text-center">
                <div class="child-sections">
                    <h1 class=".sub-titulos">Categories &#8611; Category</h1>
                </div>
                <div id="categories-table" style="width: 90%; margin-left: auto; margin-right: auto;">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Memo</th>
                                <th scope="col">Has superior?</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <th scope="row" style="background-color: {{ $category->color }}; color: white;">
                                        {{ $category->id }}</th>
                                    <td>{{ $category->description }}</td>
                                    <td title="{{ $category->memo }}">
                                        {{ \Illuminate\Support\Str::limit($category->memo, 50, $end = '...') }}
                                    </td>
                                    <td>{{ $category->category->description ?? 'Super Category' }}</td>
                                    <td>
                                        @if ($category->user_id == auth()->id())
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a onclick="editCategory({{ $category->id }})"
                                                    class="btn btn-info">Edit</a>
                                                <a href="javascript:void(0)"
                                                    onclick="deleteCategory({{ $category->id }})"
                                                    class="btn btn-danger">Delete</a>
                                            </div>
                                        @else
                                            <a href="javascript:void(0)" class="btn btn-secondary disabled">by
                                                {{ $category->user }}</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $categories->withQueryString()->links() }}
                    {{ $categories->total() > 0 ? $categories->total() . ' - registro(s) encontrado(s).' : 'nenhum registro encontrado.' }}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                </div>
                <form id="CodeLinkForm">
                    <div class="modal-body" id='formLabel'>
                        @csrf
                        <div class="form-group" id="categories_options_link">
                            <select name="code_categories_id" multiple required class="custom-select" id="code_category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="editCategoryModal" class="modal fade bd-example-modal-lg-edit" tabindex="-1" role="dialog"
        aria-labelledby="asdfmyLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div style="width: 95%; margin: auto;">
                    <div id="modal-action" style="text-align: center; margin-top: 3%;">
                        <h3>Category update</h3>
                    </div>
                    <form id="CategoryEditForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label style="font-size: 18px;" for="exampleFormControlInput1">Category name</label>
                            <input required type="text" id="ccategory_description1" name="ccategory_description" value=""
                                class="form-control" placeholder="The name of your category">
                        </div>
                        <div class="form-group">
                            <label class="unselectable" for="exampleFormControlSelect1">Color</label>
                            <input type="color" id="ccolor" class="btn btn-secondary" style="width: 5%">
                            <input type="text" required name="ccategory_color" class="form-control" id="cchoosen-color1"
                                placeholder="#0000FF">
                        </div>
                        <div class="form-group" id="categories_options_2">
                            <select name="ccategory_id" class="" id="ccategory_category_id1">
                                <option value="">Select one category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="unselectable" for="exampleFormControlTextarea1">Memo</label>
                            <textarea required class="form-control" name="ccategory_memo"
                                placeholder="This refactoring make a code more succinct and more readably..."
                                id="ccategory_memo1" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-12 text-center">
                            <input type="submit" class="btn btn-success col-md-4" value="Update category">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Large modal -->
    <div id="myModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div style="width: 95%; margin: auto;">
                    <div id="modal-action" style="text-align: center; margin-top: 3%;">
                        <h3>Category registration</h3>
                    </div>
                    <form id="CategoryForm">
                        @csrf
                        <input type="hidden" id="project_id" name="project_id" value="{{ $project->id }}">
                        <input type="hidden" id="user_id" name="user_id" value="{{ auth()->id() }}">
                        <div class="form-group">
                            <label style="font-size: 18px;" for="exampleFormControlInput1">Category name</label>
                            <input required type="text" id="ccategory_description" name="category_description"
                                value="{{ old('category_description') ?? '' }}" class="form-control"
                                placeholder="The name of your category">
                        </div>
                        <div class="form-group">
                            <label class="unselectable" for="exampleFormControlSelect1">Color</label>
                            <input type="color" id="color" class="btn btn-secondary" style="width: 5%">
                            <input type="text" required name="category_color" class="form-control" id="choosen-color"
                                placeholder="#0000FF">
                        </div>
                        <div class="form-group" id="categories_options">
                            <select name="category_id" class="custom-select" id="ccategory_category_id">
                                <option value="">Select one category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="unselectable" for="exampleFormControlTextarea1">Memo</label>
                            <textarea required class="form-control" name="category_memo"
                                placeholder="This refactoring make a code more succinct and more readably..."
                                id="ccategory_memo" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-12 text-center">
                            <input type="submit" class="btn btn-success col-md-4" value="Register">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @component('app.layouts._partials.js-import')
    @endcomponent

    <script>
        function FreshCategoriesOptions() {
            $('#categories_options').load(document.URL + ' #categories_options');
        }

        function deleteCategory(id) {

            if (confirm("Do you really want to delete this Category?")) {
                $.ajax({
                    url: '/category/' + id,
                    type: 'DELETE',
                    data: {
                        _token: $("input[name=_token]").val()
                    },
                    success: function(response) {
                        $('#categories-table').load(document.URL + ' #categories-table');
                        $('#codes-table').load(document.URL + ' #codes-table');
                    },
                    error: function(data) {
                        console.log(data);
                    }
                })
            }
        }

        function editCategory(id) {
            $.get("/category/" + id + "/edit", function(category) {
                console.log(category.category_id);
                $('#CategoryEditForm')[0].reset();
                $('#categories_options_2').load(document.URL + ' #categories_options_2');
                document.getElementById("ccategory_description1").value = category.description;
                document.getElementById("cchoosen-color1").value = category.color;
                document.getElementById("ccategory_memo1").innerHTML = category.memo;
                $('#categoryId').remove();
                $.get('/options-category/' + id, function(categories) {
                    $("#ccategory_category_id1").empty();
                    $("#ccategory_category_id1").append("<option value=''>Select one category</option>");
                    if (categories) {
                        $.each(categories, function(key, value) {
                            if (key == category.category_id) {
                                $('#ccategory_category_id1').append("<option value='" + key +
                                    "' selected>" + value + "</option>");
                            } else {
                                $('#ccategory_category_id1').append($("<option/>", {
                                    value: key,
                                    text: value
                                }));
                            }
                        });
                    }
                });

                var new_input = "<input type='hidden' id='categoryId' name='ccategory' value='" + id + "'>";
                $('#CategoryEditForm').append(new_input);
                $("#editCategoryModal").modal("toggle");
            });
        }

        function setSelected(id) {
            document.getElementById("ccategory_category_id1").value = id;
        }

        function getIdcode(id, description, type) {

            $('#CodeLinkForm')[0].reset();
            document.getElementById("exampleModalCenterTitle").innerHTML = "<b>Code:</b> " + description;
            $("#codeId").remove();
            var new_input = "<input type='hidden' id='codeId' name='code_id' value='" + id + "'>";
            $('#CodeLinkForm').append(new_input);

            $("#codeId").remove();
            var new_input = "<input type='hidden' id='codeId' name='code_id' value='" + id + "'>";
            $('#CodeLinkForm').append(new_input);

            if (type == 'link') {
                $.get('/show-categories/' + id, function(categories) {
                    document.getElementById("categories_options_link").innerHTML = categories;
                });
                $("#type-link").remove();
                var new_type = "<input type='hidden' name='type' id='type-link' value='" + type + "'>";
                $('#CodeLinkForm').append(new_type);
            } else {
                $.get('/show-categories-deslink/' + id, function(categories) {
                    document.getElementById("categories_options_link").innerHTML = categories;
                });
                $("#type-link").remove();
                var new_type = "<input type='hidden' name='type' id='type-link' value='" + type + "'>";
                $('#CodeLinkForm').append(new_type);
            }
        }


        $('#CodeLinkForm').submit(function(e) {
            e.preventDefault();

            var id = $("input[name=code_id]").val();
            var _token = $("input[name=_token]").val();
            var categories = $("select[name=code_categories_id]").val();
            var type = $("input[name=type]").val();

            if (type == 'link') {
                $.ajax({
                    url: "{{ route('code.link.categories') }}",
                    type: "POST",
                    data: {
                        id: id,
                        categories: categories,
                        _token: _token
                    },
                    success: function(response) {
                        $("#exampleModalCenter").modal("toggle");
                        $('#CodeLinkForm')[0].reset();
                        $('#codes-table').load(document.URL + ' #codes-table');
                    },
                    error: function(data) {
                        console.log(data);
                    }
                })
            } else {
                $.ajax({
                    url: "{{ route('deslink.categories') }}",
                    type: "POST",
                    data: {
                        id: id,
                        categories: categories,
                        _token: _token
                    },
                    success: function(response) {
                        $("#exampleModalCenter").modal("toggle");
                        $('#CodeLinkForm')[0].reset();
                        $('#codes-table').load(document.URL + ' #codes-table');
                    },
                    error: function(data) {
                        console.log(data);
                    }
                })
            }

        });



        $('#CategoryForm').submit(function(e) {
            e.preventDefault();
            $('#categories_options').load(document.URL + ' #categories_options');

            var project_id = $("input[name=project_id]").val();
            var color = $("input[name=category_color]").val();
            var memo = $("textarea[name=category_memo]").val();
            var description = $("input[name=category_description]").val();
            var user_id = $("input[name=user_id]").val();
            var _token = $("input[name=_token]").val();
            var category_id = $("select[name=category_id]").val();

            $.ajax({
                url: "{{ route('category.store') }}",
                type: "POST",
                data: {
                    project_id: project_id,
                    user_id: user_id,
                    category_id: category_id,
                    color: color,
                    memo: memo,
                    description: description,
                    _token: _token
                },
                success: function(response) {
                    $("#myModal").modal("toggle");
                    $('#CategoryForm')[0].reset();
                    $('#categories-table').load(document.URL + ' #categories-table');
                },
                error: function(data) {
                    var errors = data.responseText;
                    var jsonResponse = JSON.parse(errors);
                    $.each(jsonResponse.errors, function(key, value) {
                        $('#ccategory_' + key).after(
                            "<div class='alert alert-danger' id='alert_" +
                            key + "' role='alert'>" + value + "</div>");
                        setTimeout(function() {
                            $('#alert_' + key).remove();
                        }, 4000);
                    });
                }
            })
        });

        $('#CategoryEditForm').submit(function(e) {
            e.preventDefault();

            var id = $("input[name=ccategory]").val();
            var color = $("input[name=ccategory_color]").val();
            var memo = $("textarea[name=ccategory_memo]").val();
            var description = $("input[name=ccategory_description]").val();
            var _token = $("input[name=_token]").val();
            var _method = $("input[name=_method]").val();
            var category_id = $("select[name=ccategory_id]").val();


            $.ajax({
                url: "{{ route('category.update') }}",
                type: "POST",
                data: {
                    id: id,
                    category_id: category_id,
                    color: color,
                    memo: memo,
                    description: description,
                    _token: _token,
                    _method: _method
                },
                success: function(response) {
                    $("#editCategoryModal").modal("toggle");
                    $('#CategoryEditForm')[0].reset();
                    $('#categories-table').load(document.URL + ' #categories-table');
                    $('#codes-table').load(document.URL + ' #codes-table');
                },
                error: function(data) {
                    var errors = data.responseText;
                    var jsonResponse = JSON.parse(errors);
                    $.each(jsonResponse.errors, function(key, value) {
                        alert(key + ": " + value);
                    });
                }
            })
        });

        jQuery('#color').on('change', function() {
            $("input#choosen-color").val(jQuery(this).val());
        });


        jQuery('#ccolor').on('change', function() {
            $("input#cchoosen-color1").val(jQuery(this).val());
        });

        $(function() {
            $('[data-toggle="popover"]').popover();
        })
        $('.popover-dismiss').popover({
            trigger: 'focus'
        })
    </script>

@endsection
