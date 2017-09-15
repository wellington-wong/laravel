
<div class="container-with-sidebar">
	<div class="lb-wrap">
		<div class="lb-wrap-head">
			Leaderboard<br />
<span>(only includes leads submitted since {{ date('M d, Y', strtotime( date('Y') . '-01-01' )) }})</span>
		</div>
		<div style="padding: 20px !important;">
			{{--<div class="pager">{{ $users->links() }}</div>--}}
			
			<table style="width: 100%;margin: 20px 0;" cellspacing="8">
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
	</div>
</div>

