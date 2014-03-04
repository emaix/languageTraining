<?php include("dbOpen.php"); ?>
<?php include("utils.php"); ?>

<html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <title>Czech Time</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="UTF-8">
    
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        
        <!-- JQuery -->
        <script src="/jquery/jquery-1.10.2.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="/bootstrap/js/bootstrap.min.js"></script>
        
        <script type="text/javascript">
            $(document).ready(function(){
                $("#search-filter").keyup(function(){

                    // Retrieve the input field text and reset the count to zero
                    var filter = $(this).val(), count = 0;

                    // Loop through the comment list
                    $(".search-results").each(function(){

                        // If the list item does not contain the text phrase fade it out
                        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                            $(this).fadeOut();

                            // Show the list item if the phrase matches and increase the count by 1
                        } else {
                            $(this).show();
                            count++;
                        }
                    });

                    // Update the count
                    var numberItems = count;
                    //$("#filter-count").text("Number of Comments = "+count);
                });
            });
        </script>
        
        
        <style type="text/css">
            
            body
            {
                background-image: url("/images/cz.jpg");
                background-size:100% 100%;
                background-repeat: no-repeat;
                background-attachment: fixed;
            }
            
            .body-wrapper
            {
                width: 80% ;
                margin-left: auto ;
                margin-right: auto ;
            }
            
        </style>
    
    </head>
    
    <body>
        <div class="body-wrapper">
            <table width="100%">
                <tr>
                    <td>
                        <h1>
                            <a href="index.php" style="text-decoration: none;"><span class="label label-danger">Czech Time</span></a>
                        </h1>
                    </td>
                    <td align="right">
                        <h2><input type="text" placeholder="Search..." id="search-filter" onfocus="$('#searchResults').show('fast');" /></h2>
                    </td>
                </tr>
            </table>
        </div>
            
        <br />
        <div id="" class="body-wrapper well">
            <div id="searchResults" style="display:none;">
                <h2>
                    Search Results
                    <a href="#" onclick="$('#searchResults').hide('fast');" class="btn btn-warning pull-right">
                        Close Search Results
                    </a>
                </h2>
                
                
                <table class="table table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>Cz</th>
                            <th>En</th>
                            <th>Type</th>
                            <th>Comments</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($word = mysql_fetch_array($searchResult)) { ?>
                            <tr class="search-results">           
                                <td><?php echo $word['cz']; ?></td>
                                <td><?php echo $word['en']; ?></td>
                                <td><?php echo $vocabularyType[$word['type']]; ?></td>
                                <td><?php echo $word['comments']; ?></td>
                                <td align="right"><a href="updateVocabulary.php?vocabularyId=<?php echo $word["id"]; ?>" class="btn btn-default btn-sm">Update</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
                <br /><hr width="100%" /><br />
            </div>
        