<thead>
    <tr>
        <th>Video Id</th>
        @if($user_role_id == '2' || $user_role_id == '5') 
            <th>Discipline</th>
        @endif
        <th>Submission Date</th>
        <th>Last Video Status</th>
        <th>Last Updated Date</th>
        {{-- @if($user_role_id == '3')
        <th>Pass to another editorial member</th>
        @endif --}}
        <th>Operation</th>
    </tr>
</thead>