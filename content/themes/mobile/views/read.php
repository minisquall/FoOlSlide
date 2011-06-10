<div data-role="content">
	<ul data-role="listview" data-theme="c" data-dividertheme="b">
		<div class="images_loader" onClick="nextPage()"><img style="width:100%;" src="" /></div>
	</ul>
</div>

<script src="<?php echo site_url(); ?>assets/js/jquery.plugins.js"></script>
<script type="text/javascript">
	
	var pages = <?php echo json_encode($pages); ?>;

	var next_chapter = "<?php echo $next_chapter; ?>";
	
	var preload_next = 2;

	var preload_back = 0;

	var current_page = <?php echo $current_page - 1; ?>;
	
	function changePage(id, noscroll)
	{
		id = parseInt(id);
		if(id > pages.length-1) 
		{
			jQuery.mobile.changePage(next_chapter, "slidedown");	
			return false;
		}
		
		preload(id);
		next = parseInt(id+1);
		jQuery('.images_loader img').remove();
		jQuery('.images_loader').html('<img style="width:100%" src="' + pages[id].url + '" />');
		current_page = id;
		scroll(0,0);
		return false;
	}
	
	function nextPage()
	{
		current_page++;
		changePage(current_page);
	}
	
	function prevPage()
	{
		current_page--;
		changePage(current_page);
	}
	
	function preload(id)
	{
		array = [];
		arraydata = [];
		for(i = -preload_back; i < preload_next; i++)
		{
			if(id+i >= 0 && id+i < pages.length)
			{
				array.push(pages[(id+i)].url);
				arraydata.push(id+i);
			}
		}
		jQuery.preload(array, {
			threshold: 200,
			enforceCache: true,
			onComplete:function(data)
			{
				pages[arraydata[data.index]].loaded = true;
			}
	
		});
	}
	
	jQuery(document).ready(function(){
		changePage(0);
		jQuery(".images_loader").touchwipe({
			wipeLeft: function() { 
				nextPage();
			},
			wipeRight: function() { 
				prevPage();
			},
			//wipeUp: function() { alert("up"); },
			//wipeDown: function() { alert("down"); },
			min_move_x: 40,
			preventDefaultEvents: false
		});
		
	});

</script>