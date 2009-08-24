<?php

class topDeputesTask extends sfBaseTask
{
  protected function configure()
  {
    $this->namespace = 'top';
    $this->name = 'Deputes';
    $this->briefDescription = 'Top Deputes';
  }
 
  protected function orderDeputes($type, $reverse = 1) {
    foreach(array_keys($this->deputes) as $id) {
      if (!isset($this->deputes[$id][$type]['value'])) 
	$this->deputes[$id][$type]['value'] = 0;
      $ordered[$id] = $this->deputes[$id][$type]['value'];
    }
    if ($reverse)
      arsort($ordered);
    else
      asort($ordered);
      
    $cpt = 0;
    foreach(array_keys($ordered) as $id) {
      $cpt++;
      $this->deputes[$id][$type]['rank'] = $cpt;
    }
  }

  protected function execute($arguments = array(), $options = array())
  {
    $manager = new sfDatabaseManager($this->configuration);
    
    $this->deputes = array();

    $semaines = Doctrine_Query::create()
      ->select('p.id, s.numero_semaine, pr.id, count(s.id)')
      ->from('Parlementaire p, p.Presences pr, pr.Seance s')
      ->groupBy('p.id, s.numero_semaine')
      ->where('s.date > ?', date('Y-m-d', time()-60*60*24*365))
      ->andWhere('fin_mandat IS NULL')
      ->fetchArray();
    foreach ($semaines as $p) {
      foreach($p['Presences'] as $pr) {
	$this->deputes[$p['id']]['semaine']['value']++;
      }
    }
    $this->orderDeputes('semaine');
    

    $parlementaires = Doctrine_Query::create()
      ->select('p.id, count(pr.id)')
      ->from('Parlementaire p, p.Presences pr, pr.Seance s')
      ->groupBy('p.id')
      ->where('s.date > ?', date('Y-m-d', time()-60*60*24*365))
      ->andWhere('fin_mandat IS NULL')
      ->andWhere('s.type = ?', 'commission')
      ->fetchArray();
    foreach ($parlementaires as $p) {
      $this->deputes[$p['id']]['commission_presences']['value'] = $p['count'];
    }
    $this->orderDeputes('commission_presences');
    

    $parlementaires = Doctrine_Query::create()
      ->select('p.id, count(i.id)')
      ->from('Parlementaire p, p.Interventions i')
      ->groupBy('p.id')
      ->where('i.date > ?', date('Y-m-d', time()-60*60*24*365))
      ->andWhere('fin_mandat IS NULL')
      ->andWhere('i.type = ?', 'commission')
      ->fetchArray();
    foreach ($parlementaires as $p) {
      $this->deputes[$p['id']]['commission_interventions']['value'] = $p['count'];
    }
    $this->orderDeputes('commission_interventions');
    


    $parlementaires = Doctrine_Query::create()
      ->select('p.id, count(i.id)')
      ->from('Parlementaire p, p.Interventions i, i.Seance s')
      ->groupBy('p.id')
      ->where('i.date > ?', date('Y-m-d', time()-60*60*24*365))
      ->andWhere('fin_mandat IS NULL')
      ->andWhere('s.type = ?', 'hemicycle')
      ->andWhere('i.nb_mots > 20')
      ->fetchArray();
    foreach ($parlementaires as $p) {
      $this->deputes[$p['id']]['hemicycle_interventions']['value'] = $p['count'];
    }
    $this->orderDeputes('hemicycle_interventions');
    

    $parlementaires = Doctrine_Query::create()
      ->select('p.id, count(i.id)')
      ->from('Parlementaire p, p.Interventions i, i.Seance s')
      ->groupBy('p.id')
      ->where('i.date > ?', date('Y-m-d', time()-60*60*24*365))
      ->andWhere('fin_mandat IS NULL')
      ->andWhere('s.type = ?', 'hemicycle')
      ->andWhere('i.nb_mots < 20')
      ->fetchArray();
    foreach ($parlementaires as $p) {
      $this->deputes[$p['id']]['hemicycle_invectives']['value'] = $p['count'];
    }
    $this->orderDeputes('hemicycle_invectives');
    
    foreach (array_keys($this->deputes) as $id) {
      if ($this->deputes[$id]['hemicycle_invectives']['value'] + $this->deputes[$id]['hemicycle_interventions']['value'])
	$this->deputes[$id]['hemicycle_ratio']['value'] = 
	  $this->deputes[$id]['hemicycle_interventions']['value'] * 100 / 
	  ($this->deputes[$id]['hemicycle_invectives']['value'] + $this->deputes[$id]['hemicycle_interventions']['value']);
      else 
	$this->deputes[$id]['hemicycle_ratio']['value'] = 0;
    }
    $this->orderDeputes('hemicycle_ratio');


    $parlementaires = Doctrine_Query::create()
      ->select('p.id, count(a.id)')
      ->from('Parlementaire p, p.Amendements a')
      ->groupBy('p.id')
      ->where('a.date > ?', date('Y-m-d', time()-60*60*24*365))
      ->andWhere('fin_mandat IS NULL')
      ->fetchArray();
    foreach ($parlementaires as $p) {
      $this->deputes[$p['id']]['amendements_signes']['value'] = $p['count'];
    }
    $this->orderDeputes('amendements_signes');
    

    $parlementaires = Doctrine_Query::create()
      ->select('p.id, count(a.id)')
      ->from('Parlementaire p, p.Amendements a')
      ->groupBy('p.id')
      ->where('a.date > ?', date('Y-m-d', time()-60*60*24*365))
      ->andWhere('fin_mandat IS NULL')
      ->andWhere('a.sort = ?', 'Adopté')
      ->fetchArray();
    foreach ($parlementaires as $p) {
      $this->deputes[$p['id']]['amendements_adoptes']['value'] = $p['count'];
    }
    $this->orderDeputes('amendements_adoptes');

    $parlementaires = Doctrine_Query::create()
      ->select('p.id, count(a.id)')
      ->from('Parlementaire p, p.Amendements a')
      ->groupBy('p.id')
      ->where('a.date > ?', date('Y-m-d', time()-60*60*24*365))
      ->andWhere('fin_mandat IS NULL')
      ->andWhere('a.sort = ?', 'Rejeté')
      ->fetchArray();
    foreach ($parlementaires as $p) {
      $this->deputes[$p['id']]['amendements_rejetes']['value'] = $p['count'];
    }
    $this->orderDeputes('amendements_rejetes');

    $parlementaires = Doctrine_Query::create()
      ->select('p.id, count(a.id)')
      ->from('Parlementaire p, p.Amendements a')
      ->groupBy('p.id')
      ->where('a.date > ?', date('Y-m-d', time()-60*60*24*365))
      ->andWhere('fin_mandat IS NULL')
      ->andWhere('(a.sort = ? OR a.sort = ?)', array('Retiré', 'Non soutenu'))
      ->fetchArray();
    foreach ($parlementaires as $p) {
      $this->deputes[$p['id']]['amendements_retires']['value'] = $p['count'];
    }
    $this->orderDeputes('amendements_retires');


    foreach(array_keys($this->deputes) as $id) {
      $depute = Doctrine::getTable('Parlementaire')->find($id);
      $depute->top = serialize($this->deputes[$id]);
      $depute->save();
    }
  }
}
