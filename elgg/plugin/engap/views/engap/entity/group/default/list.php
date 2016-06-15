<ons-list-item modifier="chevron" style='border-bottom:1px solid #DADADA;overflow:auto;line-height:25px;'> 
 <div ng-click='loadentity()' style='border-radius:3px;width:50px;display:inline;'>
  <entityicon style='border-radius:5px;' width='48px' alt='group icon' />
 </div>
 <div ng-click='loadentity()' style='float:right;width:82%;'>
  <div class='entry-title'>
   {{content.title}}
  </div>
  <div class='entry-copy' style='font-size: 12px;'>
   {{content.description}}
  </div>
 </div>
</ons-list-item>