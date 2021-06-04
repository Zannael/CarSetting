def gen_insert(nome_tabella):

# ["id", "prezzo", "alimentazione", "marca", "carrozzeria", "trazione", "equipaggiamenti",
# "dimensioni", "posti", "porte", "emissione", "motore", "classe_emissione", "cambio",
# "imageurl"]

    lista = [
        {
            "name": "Renault Nuova Clio",
            "prezzo": 16400,
            "alimentazione": "Benzina # GPL # Full hybrid",
            "marca": "Renault",
            "carrozeria": "Berlina",
            "trazione": "Anteriore",
            "dimensioni": "lu=405 # al=144 # la=179",
            "posti": 5,
            "porte": 5,
            "emissione": "119 - 99",
            "motore": "pot=65/48 - 140/103 # cil=999 - 1598",
            "cambio": "Manuale # Automatico",
            "imageurl": "images/nuovaclio.png"
        },
        {
            "name": "Opel Nuova Corsa",
            "prezzo": 15950,
            "alimentazione": "Benzina # Diesel",
            "marca": "Opel",
            "carrozeria": "Berlina",
            "trazione": "Anteriore",
            "dimensioni": "lu=406 # al=143 # la=176",
            "posti": 5,
            "porte": 5,
            "emissione": "123 - 105",
            "motore": "pot=75/55 - 130/96 # cil=1199 - 1499",
            "cambio": "Manuale # Automatico",
            "imageurl": "images/nuovacorsa.png"
        },
        {
            "name": "Dacia Nuova Sandero",
            "prezzo": 8950,
            "alimentazione": "Benzina # GPL",
            "marca": "Dacia",
            "carrozeria": "Berlina",
            "trazione": "Anteriore",
            "dimensioni": "lu=406 # al=151 # la=173",
            "posti": 5,
            "porte": 5,
            "emissione": "131 - 108",
            "motore": "pot=67/49 - 101/74 # cil=999",
            "cambio": "Manuale # Automatico",
            "imageurl": "images/nuovasandero.png"
        },
        {
            "name": "Citroen Nuova C4",
            "prezzo": 23150,
            "alimentazione": "Benzina # Diesel",
            "marca": "Citroen",
            "carrozeria": "Berlina",
            "trazione": "Anteriore",
            "dimensioni": "lu=436 # al=152 # la=180",
            "posti": 5,
            "porte": 5,
            "emissione": "132 - 113",
            "motore": "pot=110/81 - 131/96 # cil=1199 - 1499",
            "cambio": "Manuale # Automatico",
            "imageurl": "images/nuovac4.png"         
        }
    ]

    id = 0
    for dic in lista:
        valori = ""
        valori += str(id) + ", "
        keys = list(dic.keys())

        for k in dic:
            value = dic[k]
            if type(value) == str: valori += '"' + value + '"'
            else: valori += str(value)
            if k != keys[-1]: valori += ", "

        query_string = "INSERT into " + nome_tabella + " VALUES (" + valori + ");"
        print(query_string)

gen_insert("veicoli")