

<div class="form-group">
    <label for="{{ $name }}">{{ Str::ucfirst($cn ?? $name) }}</label>
    <input type="{{ $type }}" name="{{ $name }}" value="{{ $value ?? old($name) }}"
    class="form-control {{ $class ?? '' }} @error($name) is-invalid @enderror" id="{{ $name }}" {{ $req ?? '' }} {{ $m ?? '' }}>
    @error($name)
      <small class="text text-danger">{{ $message }}</small>
    @enderror
</div>
