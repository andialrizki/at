	
	<div class="footer">
		<div class="container body_wrapper">
			<div class="row">
				<div class="col-sm-4 div-brand">
					<a class="navbar-brand">AtPitstop</a>
				</div>
				<div class="col-sm-8">
					<div style="text-align:right">
						<button class="btn btn-no-radius btn-danger"><i class="fa fa-arrow-up"></i></button>
					</div>
				</div>
			</div>
			<div class="row">
				<p class="text-center copyright">
					&copy; 2016 AtPitstop.com All Right Reserved. by semicolon
				</p>
			</div>
		</div>
	</div>

  </body>
</html>
<?php $endScriptTime=microtime(TRUE); ?>
<?php $totalScriptTime=$endScriptTime-$startScriptTime;
echo "\n\r".'<script>console.log(" Full Load time: '.number_format($totalScriptTime, 4).' seconds ");</script>'; ?>