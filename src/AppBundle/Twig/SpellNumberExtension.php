<?php

namespace AppBundle\Twig;

class SpellNumberExtension extends \Twig_Extension
{
    const SPELLNUMBER_SEPARATOR = '';
    const SPELLNUMBER_SEPARATOR_1 = 'et';
    const SPELLNUMBER_0 = 'zero';
    const SPELLNUMBER_1 = 'un';
    const SPELLNUMBER_2 = 'deux';
    const SPELLNUMBER_3 = 'trois';
    const SPELLNUMBER_4 = 'quatre';
    const SPELLNUMBER_5 = 'cinq';
    const SPELLNUMBER_6 = 'six';
    const SPELLNUMBER_7 = 'sept';
    const SPELLNUMBER_8 = 'huit';
    const SPELLNUMBER_9 = 'neuf';
    const SPELLNUMBER_10 = 'dix';
    const SPELLNUMBER_11 = 'onze';
    const SPELLNUMBER_12 = 'douze';
    const SPELLNUMBER_13 = 'treize';
    const SPELLNUMBER_14 = 'quatorze';
    const SPELLNUMBER_15 = 'quinze';
    const SPELLNUMBER_16 = 'seize';
    const SPELLNUMBER_17 = 'dix-sept';
    const SPELLNUMBER_18 = 'dix-huit';
    const SPELLNUMBER_19 = 'dix-neuf';
    const SPELLNUMBER_20 = 'vingt';
    const SPELLNUMBER_30 = 'trente';
    const SPELLNUMBER_40 = 'quarante';
    const SPELLNUMBER_50 = 'cinquante';
    const SPELLNUMBER_60 = 'soixante';
    const SPELLNUMBER_70 = 'soixante';
    const SPELLNUMBER_71 = 'soixante et onze';
    const SPELLNUMBER_72 = 'soixante douze';
    const SPELLNUMBER_73 = 'soixante treize';
    const SPELLNUMBER_74 = 'soixante quatorze';
    const SPELLNUMBER_75 = 'soixante quinze';
    const SPELLNUMBER_76 = 'soixante seize';
    const SPELLNUMBER_77 = 'soixante dix-sept';
    const SPELLNUMBER_78 = 'soixante dix-huit';
    const SPELLNUMBER_79 = 'soixante dix-neuf';
    const SPELLNUMBER_80 = 'quatre-vingt';
    const SPELLNUMBER_90 = 'quatre-vingt';
    const SPELLNUMBER_91 = 'quatre-vingt onze';
    const SPELLNUMBER_92 = 'quatre-vingt douze';
    const SPELLNUMBER_93 = 'quatre-vingt treize';
    const SPELLNUMBER_94 = 'quatre-vingt quatorze';
    const SPELLNUMBER_95 = 'quatre-vingt quinze';
    const SPELLNUMBER_96 = 'quatre-vingt seize';
    const SPELLNUMBER_97 = 'quatre-vingt dix-sept';
    const SPELLNUMBER_98 = 'quatre-vingt dix-huit';
    const SPELLNUMBER_99 = 'quatre-vingt dix-neuf';
    const SPELLNUMBER_100 = 'cent';
    const SPELLNUMBER_200 = 'deux cent';
    const SPELLNUMBER_300 = 'trois cent';
    const SPELLNUMBER_400 = 'quatre cent';
    const SPELLNUMBER_500 = 'cinq cent';
    const SPELLNUMBER_600 = 'six cent';
    const SPELLNUMBER_700 = 'sept cent';
    const SPELLNUMBER_800 = 'huit cent';
    const SPELLNUMBER_900 = 'neuf cent';
    const SPELLNUMBER_1000 = 'mille';
    const SPELLNUMBER_1000000 = 'million';
    const SPELLNUMBER_1000000000 = 'milliard';
    const SPELLNUMBER_1000000000000 = 'trillion';

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('number_to_string', [$this, 'numberToStringFilter']),
        ];
    }

    public function numberToStringFilter($number)
    {
        $ret_str = '';
        while ($number != '') {
            $part = (int)((strlen($number) - 1) / 3);
            $sub_len = strlen($number) - $part * 3;
            if ($sub_len == 0) {
                $sub_len = 3;
            }
            $sub_num = substr($number, 0, $sub_len);
            $number = substr($number, $sub_len);

            $ret_sub_str = '';
            while ($sub_num != '') {
                while (($sub_num != '') && ($sub_num[0] == '0')) {
                    if (strlen($sub_num) == 1) {
                        $sub_num = '';
                    } else {
                        $sub_num = substr($sub_num, 1);
                    }
                }
                $sub_len = strlen($sub_num);
                switch ($sub_len) {
                    case 3:
                        $ret_sub_str = $this->digitName($sub_num[0], 2);
                        $sub_num = substr($sub_num, 1);
                        break;
                    case 2:
                        if ($sub_num[0] == '1' || $sub_num[0] == '7' || $sub_num[0] == '9') {
                            $ret_sub_str = $ret_sub_str.
                                (($ret_sub_str == '') ? '' : (self::SPELLNUMBER_SEPARATOR.' ')).
                                $this->twoDigitName($sub_num);
                            $sub_num = '';
                        } else {
                            $ret_sub_str = $ret_sub_str.
                                (($ret_sub_str == '') ? '' : (self::SPELLNUMBER_SEPARATOR.' ')).
                                $this->digitName($sub_num[0], 1);
                            //si c'est une dizaine et que l'unité et un "un", on ajoute "et"
                            if ($sub_num[1] == '1') {
                                $ret_sub_str .= ' '.self::SPELLNUMBER_SEPARATOR_1;
                            }
                            $sub_num = substr($sub_num, 1);
                        }
                        break;
                    case 1:
                        if ($sub_num == '1' && $part == 1) { // on gère le cas du mille (on ne dit pas un mille)
                            $ret_sub_str = $ret_sub_str.
                                (($ret_sub_str == '') ? '' : (self::SPELLNUMBER_SEPARATOR.' '));
                            $french_un = true;
                        } else {
                            $ret_sub_str = $ret_sub_str.
                                (($ret_sub_str == '') ? '' : (self::SPELLNUMBER_SEPARATOR.' ')).
                                $this->digitName($sub_num, 0);
                        }
                        $sub_num = '';
                        break;
                    default:
                        $sub_num = '';
                }
            }
            $ret_str = $ret_str.
                ((($ret_sub_str != '') && ($ret_str != '')) ? (self::SPELLNUMBER_SEPARATOR.' ') : '').
                $ret_sub_str.
                (($ret_sub_str == '' && $french_un = false) ? '' : (' '.$this->groupName($part)));

            $french_un = false;
        }
        if ($ret_str == '') {
            $ret_str = self::SPELLNUMBER_0;
        }

        return $ret_str;
    }

    public function getName()
    {
        return 'spell_number_extension';
    }

    /**
     * @access  public
     * @param   int
     * @return  string
     */
    private function groupName($g_num)
    {
        if ($g_num == 0) {
            return '';
        }

        $g_str = '';
        while ($g_num > 0) {
            $g_str = $g_str.'000';
            $g_num = $g_num - 1;
        }
        $g_str = 'SPELLNUMBER_1'.$g_str;

        return constant('self::'.$g_str);
    }

    /**
     * @access  public
     * @param   int $digit
     * @param   int $order
     * @return  string
     */
    private function digitName($digit, $order)
    {
        $d_str = 'SPELLNUMBER_'.$digit;
        while ($order > 0) {
            $d_str = $d_str.'0';
            $order = $order - 1;
        }

        return constant('self::'.$d_str);
    }

    /**
     * @access  public
     * @param   int
     * @return  string
     */
    private function twoDigitName($digits)
    {
        $td_str = 'SPELLNUMBER_'.$digits;

        return constant('self::'.$td_str);
    }
}