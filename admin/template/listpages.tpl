						<div class="post aero">
							<h2>Pages</h2>
							{LISTPAGESENTRY}
							{LOOP}
							<a href="{ADMINFOLDER}index.php?action=edit&pageid={PAGEID}"><p>{PAGETITLE}</p></a>
							{/LOOP}
						</div>
