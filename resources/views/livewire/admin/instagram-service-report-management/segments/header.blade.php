<x-slot name="header">
    <tr>
        <x-our-table-th orderColumnName="started_at" :pagination="$pagination">Started At</x-our-table-th>
        <x-our-table-th orderColumnName="finished_at" :pagination="$pagination">Finised At</x-our-table-th>
        <x-our-table-th orderColumnName="url" :pagination="$pagination">Url</x-our-table-th>
        <x-our-table-th orderColumnName="account_count" :pagination="$pagination">Number of Account</x-our-table-th>
        <x-our-table-th orderColumnName="total_completed" :pagination="$pagination">Total Completed</x-our-table-th>
        <x-our-table-th orderColumnName="total_failed" :pagination="$pagination">Total Failed</x-our-table-th>
        <x-our-table-th orderColumnName="status" :pagination="$pagination">Status</x-our-table-th>
        <x-our-table-th>Detail</x-our-table-th>
    </tr>
</x-slot>
