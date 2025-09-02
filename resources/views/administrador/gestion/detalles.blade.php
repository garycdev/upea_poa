<div class="cards-list">
    <a href="{{ route('adm_pdu', ['id'=>encriptar($id_ges)]) }}">
        <div class="card 3">
            <div class="card_image">
                <img src="{{ asset('logos/6.gif') }}" />
            </div>
            <div class="card_title">
                <h3>PDU</h3>
            </div>
        </div>
    </a>

    <a href="{{ route('adm_pei', ['id'=>encriptar($id_ges)]) }}">
        <div class="card 4">
            <div class="card_image">
                <img src="{{ asset('logos/5.gif') }}" />
            </div>
            <div class="card_title title-black">
                <h3>PEI</h3>
            </div>
        </div>
    </a>
</div>
