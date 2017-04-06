@extends('layouts.app')

@section('style')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css"/>
@endsection

@section('content')
  <h1>상품 등록</h1>

  <form method="post" action="{{ route('products.store') }}" id="products-register-form">
    {!! csrf_field() !!}

    <div class="form-group">
      <label for="category" class="control-label">카테고리</label>
      <select name="category" id="category" class="form-control">
        <option>선택하세요</option>
        @foreach ($categories as $category)
          <option value="{{ $category->id }}"
            {{ old('category') == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
          </option>
        @endforeach
      </select>
      {!! $errors->first('category', '<span class="help-block">:message</span>') !!}
    </div>

    <div class="form-group">
      <label for="title" class="control-label">상품명</label>
      <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control"/>
      {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
    </div>

    <div class="form-group">
      <label for="sub_title" class="control-label">요약</label>
      <input type="text" name="sub_title" id="sub_title" value="{{ old('sub_title') }}" class="form-control"/>
      {!! $errors->first('sub_title', '<span class="help-block">:message</span>') !!}
    </div>

    <div class="form-group">
      <label for="price" class="control-label">가격</label>
      <input type="text" name="price" id="price" value="{{ old('price') }}" class="form-control"/>
      {!! $errors->first('price', '<span class="help-block">:message</span>') !!}
    </div>

    <div class="form-group">
      <label for="options" class="control-label">옵션</label>
      <input type="text" name="options[0][name]" id="options" value="{{ old('options.0.name') }}" class="form-control"/>
      <input type="text" name="options[0][value]" value="{{ old('options.0.value') }}" class="form-control"/>
      {!! $errors->first('options', '<span class="help-block">:message</span>') !!}
    </div>

    <div class="form-group">
      <label for="description" class="control-label">설명</label>
      <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ old('description') }}</textarea>
      {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
    </div>

    <div id="my-dropzone" class="dropzone" class="form-group"></div>
    {!! $errors->first('image', '<span class="help-block">:message</span>') !!}

    <div class="form-group text-center">
      <button type="submit" class="btn btn-primary">등록하기</button>
    </div>
  </form>
@endsection

@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>

  <script>
    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone('div#my-dropzone', {
      url: '/products/images',
      paramName: 'image',
      uploadMultiple: true,
      params: {
        _token: Laravel.csrfToken
      }
    });

    myDropzone.on('successmultiple', function(file, data) {
      for (var i= 0,len=data.length; i<len; i++) {
        addHiddenForm(data[i].id);
        insertImageOnDescription('description', data[i].url);
      }
    });

    var addHiddenForm = function(id) {
      $('<input>', {
        type: 'hidden',
        name: 'images[]',
        // TODO: 유효성 검사 오류로 돌아 왔을 때 이 값이 활성화되지 않습니다.
        value: id
      }).appendTo($('form#products-register-form').first());
    }

    var insertImageOnDescription = function(objId, imgUrl) {
      var caretPos = document.getElementById(objId).selectionStart;
      var content = $('#' + objId).val();
      var imgMarkdown = '![](' + imgUrl + ')';

      $('#' + objId).val(
        content.substring(0, caretPos) +
        imgMarkdown + '\n' +
        content.substring(caretPos)
      );
    };
  </script>
@endsection
