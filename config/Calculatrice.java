import java.util.Scanner;

abstract class Operation {
    abstract double calculer(double a, double b);
}

class Addition extends Operation {
    double calculer(double a, double b) {
        return a + b;
    }
}

class Soustraction extends Operation {
    double calculer(double a, double b) {
        return a - b;
    }
}

class Multiplication extends Operation {
    double calculer(double a, double b) {
        return a * b;
    }
}

class Division extends Operation {
    double calculer(double a, double b) {
        if (b == 0) {
            throw new ArithmeticException("Division par zéro");
        }
        return a / b;
    }
}

class Racine extends Operation {
    double calculer(double a, double b) {
        return Math.sqrt(a);
    }
}

class Carre extends Operation {
    double calculer(double a, double b) {
        return Math.pow(a, 2);
    }
}

class Puissance extends Operation {
    double calculer(double a, double b) {
        return Math.pow(a, b);
    }
}

class Logarithme extends Operation {
    double calculer(double a, double b) {
        return Math.log(a);
    }
}

class Exponentiel extends Operation {
    double calculer(double a, double b) {
        return Math.exp(a);
    }
}

class Sinus extends Operation {
    double calculer(double a, double b) {
        return Math.sin(a);
    }
}

class Cosinus extends Operation {
    double calculer(double a, double b) {
        return Math.cos(a);
    }
}

class Tangente extends Operation {
    double calculer(double a, double b) {
        return Math.tan(a);
    }
}

class Pi extends Operation {
    double calculer(double a, double b) {
        return Math.PI;
    }
}

class CosInverse extends Operation {
    double calculer(double a, double b) {
        return Math.acos(a);
    }
}

class SinInverse extends Operation {
    double calculer(double a, double b) {
        return Math.asin(a);
    }
}

class TanInverse extends Operation {
    double calculer(double a, double b) {
        return Math.atan(a);
    }
}

public class Calculatrice {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        System.out.println("Entrez l'opération (1: +, 2: -, 3: *, 4: /, 5: racine, 6: carré, 7: puissance, 8: log, 9: exp, 10: sin, 11: cos, 12: tan, 13: pi, 14: cos-1, 15: sin-1, 16: tan-1): ");
        int choix = scanner.nextInt();
        double a = 0, b = 0;

        if (choix >= 1 && choix <= 8) {
            System.out.println("Entrez le premier nombre: ");
            a = scanner.nextDouble();
            if (choix != 5 && choix != 6) {
                System.out.println("Entrez le deuxième nombre: ");
                b = scanner.nextDouble();
            }
        }

        Operation operation = null;

        switch (choix) {
            case 1: operation = new Addition(); break;
            case 2: operation = new Soustraction(); break;
            case 3: operation = new Multiplication(); break;
            case 4: operation = new Division(); break;
            case 5: operation = new Racine(); break;
            case 6: operation = new Carre(); break;
            case 7: operation = new Puissance(); break;
            case 8: operation = new Logarithme(); break;
            case 9: operation = new Exponentiel(); break;
            case 10: operation = new Sinus(); break;
            case 11: operation = new Cosinus(); break;
            case 12: operation = new Tangente(); break;
            case 13: operation = new Pi(); break;
            case 14: operation = new CosInverse(); break;
            case 15: operation = new SinInverse(); break;
            case 16: operation = new TanInverse(); break;
            default: System.out.println("Opération invalide"); return;
        }

        try {
            double resultat = operation.calculer(a, b);
            System.out.println("Le résultat est: " + resultat);
        } catch (Exception e) {
            System.out.println("Erreur: " + e.getMessage());
        }
    }
}