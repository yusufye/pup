<div>
    <?php
        $recordId = $getRecord()->commodity_id;
        ?>
    @if($getState())
    <button><a href="{{ route('download.client.document', ['record' => $recordId]) }}" class="btn" style="background-color: #F59E08; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;">Download</a></button>
        @endif
</div>
