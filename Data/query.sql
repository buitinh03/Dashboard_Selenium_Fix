ALTER TABLE thuocsi_vn ADD masp TEXT;
update thuocsi_vn
set nguon ='medigoapp.com'
where link like '%medigoapp.com%';
