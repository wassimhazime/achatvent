
        
      <?php
      
      $a=3;
      $b= function () use ($a) {
          echo"==================== ". $a.'<br><hr>';
      };
        $b();
        $c= function ($a, $b) {
        }
        ?>
        
        <!-- start -->
<a href='#' id='select-all'>select all</a>
<a href='#' id='deselect-all'>deselect all</a>
<a href='#' id='select-100'>select 100 elems</a>
<a href='#' id='deselect-100'>deselect 100 elems</a>
<a href='#' id='add-option'>add</a>

<button type="button" class="btn btn-default" >
  Popover on right
</button>


  <h1>Pre-selected-options</h1>
  <select multiple id="public-methods" class="searchable" >
    <option value='elem_1' selected >elem 1</option>
    <option value='elem_2'>hhhhhhh</option>
    <option value='elem_3'>elem 3</option>
    <option value='elem_4' selected>elem 4</option>
    <option value='elem_100'>elem 100</option>
  </select>
  <!-- ends -->
   <form action="#" >
        <fieldset>
            <input type="text" name="search" value="" id="id_search" />
                        <span class="loading" style="display: none">Loading...</span>
        </fieldset>
    </form>
         
<table id="table_finde" cellspacing="0">
    <thead>
        <tr>

            <th>Email</th>
            <th>Id</th>
            <th>Phone</th>
            <th>Total</th>
            <th>Ip</th>
            <th>Url</th>

            <th>Time</th>
            <th>ISO Date</th>
            <th>UK Date</th>
        </tr>
    </thead>
    <tbody>
        <tr id="noresults">
            <td colspan="9">No results</td>
        </tr>
        
                    <tr>
                        <td>adam@samba.org</td><td>24712</td><td>941-964-9252</td><td>$3670.11</td><td>79.237.76.177</td><td>http://donuts.com</td><td>17:22</td><td>2002/4/4</td><td>4/4/2002</td>

                    </tr>
                    <tr>
                        <td>muffins@gmail.com</td><td>01093</td><td>941-964-8205</td><td>$1813.17</td><td>158.183.228.135</td><td>http://mountdev.net</td><td>6:20</td><td>1970/2/11</td><td>11/2/1970</td>
                    </tr>
    </tbody>
    </table>
    

    
        
    


        
  <div id="marion"></div>
   