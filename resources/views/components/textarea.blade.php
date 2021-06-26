<div class="form-group">
    <label for="{{ $name }}">{{ Str::ucfirst($cn ?? $name) }}</label>
    <textarea name="{{ $name }}"   id="{{ $name }}" {{ $req ?? '' }}
    class="form-control {{ $class ?? '' }} @error($name) is-invalid @enderror" rows="3">{{ $value ?? old($name) }}</textarea>
    @error($name)
      <small class="text text-danger">{{ $message }}</small>
    @enderror
</div>
