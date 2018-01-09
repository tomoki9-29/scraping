<h4>CSVファイルを選択してください</h4>
<form role="form" method="post" action="{{ route('import') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="file" name="csv_file" id="csv_file">
    <div class="form-group">
        <button type="submit" class="btn btn-default btn-success">保存</button>
    </div>
</form>