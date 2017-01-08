<div class="form-group {{ ($errors->has('title') ? 'has-error': '') }}">
    <label for="title">제목</label>
    <input type="text" name="title" value="{{ old('title', $article->title) }}" class="form-control">
    {!!  $errors->first('title', '<span class="form-error">:message</span>')  !!}
</div>
<div class="form-group {{ ($errors->has('content') ? 'has-error': '') }}">
    <label for="content">본문</label>
    <textarea name="content" id="content" cols="30" rows="10"
              class="form-control">{{ old('content', $article->content) }}</textarea>
    {!!  $errors->first('content', '<span class="form-error">:message</span>')  !!}
</div>
<div class="form-group">
    <button class="btn btn-primary" type="sumbit">저장하기</button>
</div>
