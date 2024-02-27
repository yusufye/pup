<div>
    <?php
        $recordId = $getRecord()->id;
    ?>
    @if($getState())
    <a href="{{ route('download.client.certificate', ['record' => $recordId]) }}" class="btn" style="background-color: #F59E08; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;">Download</a>
    @endif
</div>
