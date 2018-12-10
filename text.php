<style type="text/css">
    .styletable
{
    font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
    font-size: 12px;
    margin: 45px;
    width: 480px;
    text-align: left;
    border-collapse: collapse;
}
.styletable thead th.rounded-company
{
    background: #b9c9fe;
}
.styletable thead th.rounded-q4
{
    background: #b9c9fe;
}
.styletable th
{
    padding: 8px;
    font-weight: normal;
    font-size: 13px;
    color: #039;
    background: #b9c9fe;
}
.styletable td
{
    padding: 8px;
    background: #e8edff;
    border-top: 1px solid #fff;
    color: #669;
}
.styletable tfoot td.rounded-foot-left
{
    background: #e8edff;
}
.styletable tfoot td.rounded-foot-right
{
    background: #e8edff;
}
.styletable tbody tr:hover td
{
    background: #d0dafd;
}

th.vTotal, th.hTotal
{
    color: red;
}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script type="text/javascript">
     $(function()
 {
      $('.hTotal').each(function(i) {
          var hTotal = 0;
          $(this).parent().find('tr:gt(0)')
            .each(function(i)
            {
                hTotal += parseInt($(this).text());
            });
          $(this).text(hTotal);
      });
      
     
 });
</script>
<table id="tbStat" class="styletable">
    <thead>
    <tr>
        <th>日期</th>
        <th>選項1</th>
        <th>選項2</th>
        <th>選項3</th>
        <th>選項4</th>
        <th>參加<br />人數</th>
    </tr>
    </thead>
    <tbody>
    
    <tr>
        <td>2009/2/12</td>
        <td>4</td>
        <td>33</td>
        <td>60</td>
        <td>6</td>
        <th class="hTotal">0</th>
    </tr>
    
    <tr>
        <td>2009/2/11</td>
        <td>59</td>
        <td>50</td>
        <td>85</td>
        <td>14</td>
        <th class="hTotal">0</th>
    </tr>
    
    <tr>
        <td>2009/2/10</td>
        <td>74</td>
        <td>60</td>
        <td>127</td>
        <td>16</td>
        <th class="hTotal">0</th>
    </tr>
    
    <tr>
        <td>2009/2/9</td>
        <td>64</td>
        <td>61</td>
        <td>118</td>
        <td>17</td>
        <th class="hTotal">0</th>
    </tr>
    
    <tr>
        <th>加總：</th>
        <th class="vTotal">0</th>
        <th class="vTotal">0</th>
        <th class="vTotal">0</th>
        <th class="vTotal">0</th>
        <th class="vTotal">0</th>
    </tr>
    </tbody>
</table>