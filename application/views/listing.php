<?php echo (isset($data))? '<div class="alert alert-danger" role="alert">'.$data.'</div>':''; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Directory Listing</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid mt-4">

  <div class="row">
    <div class="col-sm-12 text-center">
      <h1 class="h1">Files in the directory</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-2">
      <form method="post" action="<?php echo base_url('homepage/upload_file');?>" enctype="multipart/form-data">
        
        <input type="file" style="width: 13em;" onchange ="this.form.submit()" class="btn btn-info btn-sm" id="fileupload" name="fileupload" />
        
      </form>
    </div>
    <div class="col-sm-10">
      <table class="table table-hover">
        <thead>
          <th>Files</th>
          <th>Action</th>
        </thead>
        <tbody id="listingFiles">

        </tbody>
          
      </table>
    </div>
  </div>
  </div>
</div>

<script>
  const __siteUrl   = '<?php echo site_url(); ?>';
  const __uploadUrl = '<?php echo upload_url(); ?>';
  let __search      = '';

  $(document).ready(function(){
    getAllFiles();
  });

  function getAllFiles(){

    $.ajax({
        type: 'GET',
        url: __siteUrl+'homepage/list_directory',
        data:{
          'search':__search
        },
        success: function(response) {

            const responseData  = $.parseJSON(response); 
            if(responseData.success == true){
                
                let directoryList = (responseData.data).map(renderList);
                $('#listingFiles').html(directoryList);
            }
            else{
                let errorNotification = '<tr><td colspan="2" class="text-center"><div class="alert alert-danger" role="alert">';
                errorNotification += ' No Files to Found!';
                errorNotification += '</div></td></tr>';

                $('#listingFiles').html(errorNotification);
            }
            
        }
    });
  }
  
  function renderList(file){
   return `<tr id="${btoa(file)}">
        <td>${file}</td>
        <td><button class="btn btn-sm btn-danger" onclick="removeFiles('${file}')">remove</button></td>
      </tr>`;   
  }
  function removeFiles(file){
    
    let confirmation = confirm("Are you sure want to remove the file!");
    if (confirmation == true) {
      $.ajax({
          type: 'POST',
          url: __siteUrl+'homepage/remove_files',
          data:{
            'file':file
          },
          success: function(response) {

              const responseData  = $.parseJSON(response); 
              if(responseData.success == true){

                $('#'+btoa(file)).remove();
                alert(responseData.message);
              }
              else{
                alert(responseData.message);
              }
              
          }
      });
    } else {
      return false;
    }
  }
  

</script>
</body>
</html>
