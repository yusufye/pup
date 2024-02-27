<div>
    <?php

        $recordId = $getRecord()->id;
        $proficiency_id = $getRecord()->proficiency_id;

        $data_proficiency = App\Models\Proficiency::where('id',$proficiency_id)->first();
        $show_report = $data_proficiency->show_report;

        $current_date = date('Y-m-d');

        
        ?>
    @if($getState())
    <a href="{{ route('download.client.report', ['record' => $recordId]) }}" class="btn" style="background-color: #F59E08; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;">Download</a>
    @endif
</div>
