<ul class="nav justify-content-end">
    <li class="nav-item">
        <a href="{{ route('realestate.edit', $realEstate ) }}" class="nav-link">Grunddaten</a>
    </li>
{{--    <li class="nav-item">--}}
{{--        <a href="{{ route('realestate.address.index', $realEstate ) }}" class="nav-link">Adressen ({{ $realEstate->address->count() }})</a>--}}
{{--    </li>--}}
    <li class="nav-item">
        <a href="{{ route('galleries', $realEstate ) }}" class="nav-link">Gallerien ({{ $realEstate->gallery->count() }})</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('realestate.meta.index', $realEstate ) }}" class="nav-link">Metadaten ({{ $realEstate->meta->count() }})</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('realestate.text.index', $realEstate ) }}" class="nav-link">Texte ({{ $realEstate->text->count() }})</a>
    </li><li class="nav-item">
        <a href="{{ route('realestate.location.index', $realEstate ) }}" class="nav-link">Lagen ({{ $realEstate->location->count() }})</a>
    </li>
    </li><li class="nav-item">
        <a href="{{ route('pdfcreator', $realEstate ) }}" class="nav-link">PDF Creator</a>
    </li>
</ul>

