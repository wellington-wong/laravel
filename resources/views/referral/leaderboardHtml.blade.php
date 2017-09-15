<div class="lb-head">
	<h2>Leaderboard</h2>
	<p>(only includes leads submitted since Jan 01, 2017)</p>
</div>
<div class="lb-content">
	<table style="width: 100%;">
		<thead>
			<tr>
				<th>Referrals</th>
				<th>Member</th>
			</tr>
		</thead>
		<tbody>
			@foreach( $users as $user )
				<tr>
					<td>{{ $user->total_refs }}</td>
					<td>{{ $user->first_name }} {{ $user->last_name }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	{{--<div class="pager">{{ $users->links() }}</div>--}}
</div>


