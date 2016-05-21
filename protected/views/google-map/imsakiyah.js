var SIN = Math.sin, COS = Math.cos, SQRT = Math.sqrt, ATAN = Math.atan,
    TAN = Math.tan, ABS = Math.abs;

function hitung(lat, lng, timestamp) {
    var YEAR_LENGTH = 31557600;
    var timeZone = Math.floor(lng / 15);
    var obj = {
        getDelta: function () {
            var $u = 1.0 * (timestamp - (lng * 240) - 946684800) / YEAR_LENGTH;
            var $T = 2 * Math.PI * $u;

            return 0.37877 +
                23.264 * SIN($T - 1.38835706) +
                0.3812 * SIN(2 * $T - 1.443073132) +
                0.17132 * SIN(3 * $T - 1.042345536);
        },
        getET: function ()
        {
            var $u = 1.0 * (timestamp - (lng * 240) - 946684800) / YEAR_LENGTH;
            var $l0 = 2 * Math.PI * (0.779072417 + 1.000021383 * $u);

            $sub1 = -(107.34 + 0.1422 * $u) * SIN($l0) - (428.76 - 0.0372 * $u) * COS($l0);
            $sub2 = (596.04 - 0.0084 * $u) * SIN(2 * $l0) - (1.74 + 0.003 * $u) * COS(2 * $l0);
            $sub3 = (4.44 + 0.006 * $u) * SIN(3 * $l0) + (19.2 - 0.0024 * $u) * COS(3 * $l0);
            $sub4 = -12.72 * SIN(4 * $l0);

            return $sub1 + $sub2 + $sub3 + $sub4;
        },
        getTimeOfAngle: function ($dzuhur, $delta, $angle)
        {
            $delta = $delta * Math.PI / 180;
            $angle = $angle * Math.PI / 180;
            var $lintang = lat * Math.PI / 180;
            var $cosTeta = (COS($angle) - SIN($lintang) * SIN($delta)) / (COS($lintang) * COS($delta));
            if ($cosTeta < -1 || $cosTeta > 1) {
                return;
            }
            $teta = ACOS($cosTeta) * 180 / Math.PI;
            $time = $teta * 240;

            return $angle >= 0 ? $dzuhur + $time : $dzuhur - $time;
        },
        getImsakiyah: function ()
        {
            // dzuhur
            $dzuhur = (12 * 3600) + (timeZone * 3600) - (lng * 240) - this.getET();
            $delta = this.getDelta();
            $result = {};

            // $alfa = sudut matahari dari posisi tertinggi
            // fajar, $alfa = -90 - 20
            $alfa = -110;
            $result.fajar = this.getTimeOfAngle($dzuhur, $delta, $alfa);

            // sudut pembiasan
            $sp = 0.833 + 0.0347 * SQRT(100);

            // terbit matahari, $alfa = -90 - sudut pembiasan
            $alfa = -90 - $sp;
            $result.terbit = this.getTimeOfAngle($dzuhur, $delta, $alfa);

            // dhuzur
            $result.dzuhur = $dzuhur;

            // ashar, panjang bayangan = panjang benda + panjang bayangan saat dzuhur.
            $aAlfa = 1 + ABS(TAN(($delta - this.lintang) * Math.PI / 180));
            $alfa = ATAN($aAlfa) * 180 / Math.PI;
            $result.ashar = this.getTimeOfAngle($dzuhur, $delta, $alfa);

            // maghrib, $alfa = 90 + sudut pembiasan
            $alfa = 90 + $sp;
            $result.maghrib = this.getTimeOfAngle($dzuhur, $delta, $alfa);

            // isya', $alfa = 90 + 18
            $alfa = 108;
            $result.isya = this.getTimeOfAngle($dzuhur, $delta, $alfa);

            return $result;
        }
    };

    return obj.getImsakiyah();
}