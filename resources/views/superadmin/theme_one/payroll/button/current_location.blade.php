@if (isset($row->status) && in_array($row->status,['Unloaded']))
    <?php echo $row->workLocation->drop_house_number ?? ""; ?>
@else
    <?php echo $row->workLocation->pickup_house_number ?? ""; ?>
@endif
