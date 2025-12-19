<?php
header('Content-Type: application/json; charset=utf-8');
require 'backend/db.php';
$q = trim($_GET['q'] ?? '');
$out = [];

if ($q === '') { echo json_encode([]); exit; }
$like = "%{$q}%";

/* Search countries */
$stmt = $conn->prepare("SELECT id, name, short_description FROM countries WHERE name LIKE ? LIMIT 6");
$stmt->bind_param('s',$like); $stmt->execute(); $res = $stmt->get_result();
while($r = $res->fetch_assoc()){
  $out[] = ['type'=>'Country','title'=>$r['name'],'snippet'=>substr($r['short_description'],0,120),'url'=>"countries.php?cid=".$r['id']];
}
$stmt->close();

/* Search universities */
$stmt = $conn->prepare("SELECT u.id,u.name,u.short_description,c.name as country FROM universities u LEFT JOIN countries c ON u.country_id=c.id WHERE u.name LIKE ? LIMIT 6");
$stmt->bind_param('s',$like); $stmt->execute(); $res = $stmt->get_result();
while($r = $res->fetch_assoc()){
  $out[] = ['type'=>'University','title'=>$r['name'] . ' - ' . $r['country'],'snippet'=>substr($r['short_description'],0,120),'url'=>"countries.php?uid=".$r['id']];
}
$stmt->close();

/* Search scholarships */
$stmt = $conn->prepare("SELECT id,title,eligibility FROM scholarships WHERE title LIKE ? OR eligibility LIKE ? LIMIT 6");
$stmt->bind_param('ss',$like,$like); $stmt->execute(); $res = $stmt->get_result();
while($r = $res->fetch_assoc()){
  $out[] = ['type'=>'Scholarship','title'=>$r['title'],'snippet'=>substr($r['eligibility'],0,120),'url'=>"scholarships.php?sid=".$r['id']];
}
$stmt->close();

echo json_encode($out);
