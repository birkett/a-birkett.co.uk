						<div class="fadein"></div>
						<div class="post">
						<h2>Comments</h2>
						<table>
							<tr><th>Comment</th><th>Username</th><th>Timestamp</th><th>Client IP</th></tr>
							{LOOP}
							<tr>
								<td><a href="../blog/{POSTID}"><p>{COMMENT}</p></a></td>
								<td>{USERNAME}</td>
								<td>{TIMESTAMP}</td>
								<td><a href="{ADMINFOLDER}index.php?page=listcomments&ip={IP}">{IP}</a></td>
							</tr>
							{/LOOP}
						</table>
						</div>
						<div class="fadeout"></div>
