<script src="{{ asset('templates/jquery-1.11.3.min.js') }}"></script>
<script src="{{ asset('templates/jquery-ui.js') }}"></script>
<script src="{{ asset('templates/art.js') }}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    function lang() {
        return {
            language: '{{Config::get('app.locale')}}'
        };
    }
</script>


