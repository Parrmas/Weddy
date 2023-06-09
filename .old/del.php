
<?php
       
       include('connection.php');
       include('header.php');
       
        ?>  

<body>
<?php								
			$type = $_GET['type'];
			$id = $_GET['id'];

			$query = 'DELETE FROM '.$type.'
							WHERE
							id = ' . $id;
						$result = mysqli_query($db, $query) or die(mysqli_error($db));
						
?>
			<script type="text/javascript">
				alert("Successfully Deleted.");
				window.location = "<?php echo $type; ?>/index.php";
			</script>				

</body>
</html>