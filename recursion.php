<?php 
class recursion{

  public function getfeaturetest(){
          $FeatureConfigObj = loadModel('FeatureConfig', true);
          $Category=$FeatureConfigObj->findAll($condition,'id,parent_id,value');
          $set = new Set($Category);
          $CategoryList = $set->extract('{n}.FeatureConfig');
          $CategoryList = self::getTree($CategoryList,0);
          $tree = self::procHtml($CategoryList);
          echo $tree;
      }

      private function getTree($data, $pId)
      {
          $tree = '';
          foreach($data as $k => $v)
          {
              if($v['parent_id'] == $pId)
              {        
                  $v['parent_id'] = self::getTree($data, $v['id']);
                  $tree[] = $v;
              }
          }

          return $tree;
      }

      private function procHtml($tree)  a
      {
          $html = '';
          foreach($tree as $t){
              if($t['parent_id'] == ''){
                  $html .= "<li>{$t['value']}</li>";
              }else{
                  $html .= "<li>".$t['value'];
                  $html .= self::procHtml($t['parent_id']);
                  $html = $html."</li>";
              }
          }
          return $html ? '<ul>'.$html.'</ul>' : $html ;
      }
    }
