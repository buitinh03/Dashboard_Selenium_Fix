UPDATE thuocsi_vn
SET giamoi = '0', giacu = '0'
WHERE giamoi LIKE '%-%' OR giacu LIKE '%-%';


UPDATE thuocsi_vn
SET giamoi = '0', giacu = '0'
WHERE NOT giamoi ~ '^[0-9]';


update thuocsi_vn
set nguon ='medigoapp.com'
where link like '%medigoapp.com%';

