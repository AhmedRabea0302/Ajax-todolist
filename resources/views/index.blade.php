<html>

<head>
    <meta charset="utf-8">
    <title>Ajax ToDo List</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" >
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}" >
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}" >
</head>

<body>

    <div class="container">
        <div class="row">

            <br>
            <div class="col-lg-offset-3 col-lg-6">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Ajax List <a href="" id="addNew" class="pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></a> </h3>
                    </div>
                    <div class="panel-body" id="items">
                        <div class="list-group">

                            @foreach($items as $item)
                                <button type="button" class="list-group-item outItem" data-toggle="modal" data-target="#myModal">{{ $item->item }}
                                    <input type="hidden" id="itemId" value="{{ $item->id }}">
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>


                <div class="modal fade" tabindex="-1" id="myModal" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="title">Add new item</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="id">
                                <p><input type="text" placeholder="Enter Item" id="add-item" class="form-control"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="delete" data-dismiss="modal" style="display: none;">Delete</button>
                                <button type="button" class="btn btn-primary" id="saveChanges" data-dismiss="modal" style="display: none;">Save changes</button>
                                <button type="button" class="btn btn-primary" id="addButton" data-dismiss="modal">Add Item</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
{{ csrf_field() }}
            </div>

            <div class="col-lg-3">
                <input type="text" class="form-control" name="item" id="searchItem" placeholder="Search Items">
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <script>

        $(document).ready(function () {

            $(document).on('click', '.outItem', function (event) {
                var id = $(this).find('#itemId').val();
                $('#title').text('Edit Title');
                $('#delete').show(200);
                $('#saveChanges').show(200);
                $('#addButton').hide(200);
                $('#id').val(id);
                var text = $.trim($(this).text());
                $('#add-item').val(text);
            });

            $(document).on('click' , '#addNew', (function (event) {
                $('#title').text('Add new item');
                $('#delete').hide(200);
                $('#saveChanges').hide(200);
                $('#addButton').show(200);

                $('#add-item').val("");
            }));

            $(document).on('click', '#addButton', function (event) {
                var text = $('#add-item').val();

                if(text == "") {
                    alert("Please Enter Your Item");
                } else {
                    $.post('list', {'text': text, '_token': $('input[name=_token]').val()}, function (data) {
                        $('#items').load(location.href + ' #items');
                        // $('.list-group').append('<button type="button" class="list-group-item outItem" data-toggle="modal" data-target="#myModal">'+ text +'</button>')

                    });
                }

            });

            $('#delete').click(function () {
                var  id = $('#id').val();
                $.post('delete', {'id': id, '_token': $('input[name=_token]').val()}, function (data) {
                    $('#items').load(location.href + ' #items');
                });
            });
            
            $('#saveChanges').click(function () {
                var  id = $('#id').val();
                var  value = $('#add-item').val();
                $.post('update', {'id': id,'value': value, '_token': $('input[name=_token]').val()}, function (data) {
                    $('#items').load(location.href + ' #items');
                });
            });

            $( function() {
                var availableTags = [
                    "ActionScript",
                    "AppleScript",
                    "Asp",
                    "BASIC",
                    "C",
                    "C++",
                    "Clojure",
                    "COBOL",
                    "ColdFusion",
                    "Erlang",
                    "Fortran",
                    "Groovy",
                    "Haskell",
                    "Java",
                    "JavaScript",
                    "Lisp",
                    "Perl",
                    "PHP",
                    "Python",
                    "Ruby",
                    "Scala",
                    "Scheme"
                ];
                $protocol = window.location.protocol;
                $host     = window.location.host;
                $pathname = window.location.pathname;

                $link     = $protocol + '//'  + $host + $pathname;

                $rlink = $link.replace('list', 'search');

                console.log($rlink);
                $( "#searchItem" ).autocomplete({
                    source: '' + $rlink + ''
                });
            } );
        });
    </script>
</body>
</html>