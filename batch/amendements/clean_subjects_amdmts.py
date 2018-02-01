#!/usr/bin/env python
# -*- coding: utf-8 -*-

import sys, re, json

upper_first = lambda t: t[0].upper() + t[1:] if len(t) > 1 else t.upper()

clean_subject_amendements_regexp = [(re.compile(reg), res) for (reg, res) in [
    (r'\s\s+', ' '),
    (ur'[, ]+(dispositions|maisons|le haut|mesures|organisation|renforcer|lutte|anonymat|application|innover|examen|soutenir|formation|insérer|\[pour coordination\]|\(crédit du budget).*$', ''),
    (ur'^intitulé d[ue la]+ (titre|chapitre|tome|section|sous-section)', r'\1'),
    (r'((titre|chapitre|tome|section).*) \(avant .*$', r'\1'),
    (ur'(additionnell?e?s? a(vant|près).*) \((avant|après).*$', r'\1'),
    (r'(article|division)s? additionnell?e?s? a', 'a'),
    (ur'^(intitulé|créant de nouveaux droits|(avant )?pro.* de loi).*$', r'titre'),

    (ur'^(avant|après) ((titre|chapitre|tome|section) [ivx0-9]+(er)?)[\s\(]+du ((titre|chapitre|tome|section) [ivx0-9]+(er)?)\)?', r'\1 \5 \2'),
    (r'^((titre|chapitre|tome|section) [ivx0-9]+(er)?)[\s\(]+du ((titre|chapitre|tome|section) [ivx0-9]+(er)?)\)?', r'\4 \1'),
    (r'^(.*(titre|chapitre|tome|section) [ivx0-9]+(er)?)[\s\(]+du ((titre|chapitre|tome|section) [ivx0-9]+(er)?)\)?$', r'\4 \1'),

    (ur'rapport annex[ée]', 'annexe'),
    (ur'annexe n°\s*', 'annexe '),
    (ur'annexe (au|à l).*$', 'annexe'),
    (r'^article \d.*(annexe.*?)\)?$', r'\1'),
    (r'^annexe( [a-z0-9])', lambda x: 'annexe' + x.group(1).upper()),

    (r' (prem)?ier', ' 1er'),
    (r' (prem)?ier', ' 1er'),
    (r'(\d(er)?)([a-z])', r'\1 \3'),
    (r'1 er', '1er'),
    (r'unique', '1er'),
    (r'apres', u'après'),
    (r'\s*\(((avant|apr).*)\)', r' \1'),
    (ur'((après|avant) )+', r'\1'),
    (r'\s*\([^)]*\)', ''),
    (r'\s*\(.*$', ''),
    (r'^(\d)', r'article \1'),
    (r'articles', 'article'),
    (r'art(s|\.|icle|\s)*(\d+|liminaire)', r'article \2'),
    (ur"(après|avant)[l'\s]+article", r"\1 l'article"),
    (ur"(après|avant) (titre|chapitre|tome)", r"\1 le \2"),
    (r'quinquie\b', r'quinquies'),
    (r'(quinquies|ter)([ab])', r'\1 \2'),
    (r'(\d+e?r? )(a?[a-z]{0,2})$', lambda x: x.group(1) + x.group(2).upper()),
    (r'(\d+e?r? )([a-z]a+)$', lambda x: x.group(1) + x.group(2).upper()),
    (r'(\d+e?r? \S+ )([a-z]+)$', lambda x: x.group(1) + x.group(2).upper()),
    (r'(tat|itre)( [a-divx]+)(er)?', lambda x: x.group(1) + x.group(2).upper() + (x.group(3) or  "").lower()),
    (ur'iès( [A-Z]+|$)', r'ies\1'),
    (ur'(et )?[eéEÉ](tat [A-H])', r'E\2'),
    (r"(article \d+( [a-z]+?)?) (Etat [A-H])'*", r'\1 et \3'),
    (ur'( résolution)( (européenne\s*)?sur.*)?$', ur'\1 européenne'),
    (ur'^(texte .*)?(le sénat|alinéa|résolution|proposition|ppre).*$', ur'proposition de résolution européenne'),
    (r'((?:article|titre|chapitre|tome) [1I])( |$)', r'\1er\2'),
    (r'(section [1I])( |$)', ur'\1ère\2'),
]]

#(résoudre chiffres romains?)

def clean_subject(subj, silent=False):
    subj = subj.lower().strip()
    subj = subj.replace(u' ', ' ')
    subj = subj.replace(u' ', ' ')
    subj = subj.replace(u'\u0091', "'")
    subj = subj.replace(u'\u0092', "'")
    subj = subj.replace('septedecies', "septdecies")
    for regex, replacement in clean_subject_amendements_regexp:
        try:
            subj = regex.sub(replacement, subj)
        except:
            print "ERROR on", regex, replacement, subj
        subj = subj.strip(": ")
    if not silent and (u"à" in subj or (" et " in subj and not "Etat" in subj)) and not subj.startswith('motion'):
        print >> sys.stderr, ("WARNING, weird subject: %s" % subj).encode('utf-8')
    return upper_first(subj)


def run_tests():
    print "RUNNING TESTS"
    with open("tests_clean_subject.json") as f:
        test = json.load(f)
        for bad, gd in test.items():
            check = clean_subject(bad, silent=True)
            if check != gd:
                print ("ERROR cleaning %s: got %s while expected %s" % (bad, check, gd)).encode("utf-8")


if __name__ == "__main__":
    if len(sys.argv) > 1:
        run_tests()
        exit()

    for line in sys.stdin:
        stripped = line.strip()
        if not stripped:
            break
        am = json.loads(line)
        am['sujet'] = clean_subject(am['sujet'])
        print json.dumps(am, ensure_ascii=False).encode('utf-8')