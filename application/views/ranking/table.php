

<table id="custumtb">

	<thead>

		<tr>

			<th class="frist">Ranking</th>

			<th>Pengajar</th>

			<th>Modul Materi</th>

			<th class="frist">Nilai</th>

		</tr>
        
        <?php if(count($paginate['data']) > 0) { ?>
    		<?php  
    		    
    		    $i= $page_start; foreach ($paginate['data'] as $rows):
    			
    		?>
    
    			<tr>
    
    				<td><?=$rank[$rows->id_trainer.$rows->id_mapel];?></td>
    
    				<td><?=$rows->nama_trainer;?></td>
    
    				<td><?=$rows->nama_mapel;?></td>
    
    				<td><?=$rows->skor;?></td>				
    
    			</tr>
    
    		<?php $i++;endforeach ?>
    	<?php } else { ?>
    	    <tr>
    	        <td colspan="4" class="text-center">No data found</td>
    	    </tr>
    	<?php } ?>

	</thead>

<tbody>

</tbody>

</table>





