<a title="Click to mark as favorite(click again to unmark)" 
    class="favorite mt-2 {{ Auth::guest() ? 'off' : ($model->is_favorited ? 'favorited' : '') }}"
    onclick="event.preventDefault(); document.getElementById('favorite-{{ $model->id }}').submit();"
>
    <i class="fas fa-star fa-2x"></i>
    <span class="favorites-count">{{ $model->favorites_count }}</span>
</a>
<form id="favorite-{{ $model->id }}" action="/questions/{{ $model->id }}/favorites" method="POST" style="display:none;">
    @csrf
    @if($model->is_favorited)
        @method('DELETE')
    @endif
</form>