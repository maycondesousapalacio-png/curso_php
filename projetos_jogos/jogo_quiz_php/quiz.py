import os
print("Bem vindo")
perguntas = [
    {
        'Pergunta': 'O que significa PHP ?',
        'Opções':['Personal Home Page','Private Hosting Program','Public Hypertext Porcessor','Program Hypertext Page'],
        'Resposta':'Personal Home Page'
    },
    {
        'Pergunta': 'Qual é a extensão padrão dos arquivos ?',
        'Opções':['.html','.ph','.php','.js'],
        'Resposta':'.php'
    },
    {
        'Pergunta': 'Como se inicia um bloco de código PHP dentro de um arquivo HTML ?',
        'Opções':['<php>','<?php...?>','<script>','<php code>'],
        'Resposta':'<?php...?>'
    },
    {
        'Pergunta': 'Qual é a função usada para exibir algo na tela ?',
        'Opções':['print()','echo','write()','show()'],
        'Resposta':'echo'
    },
    {
        'Pergunta': 'Em PHP, como se declara uma variável ?',
        'Opções':['var nome = "Filipe"','$nome = "Filipe"','nome = "Filipe"','let nome = "Filipe"'],
        'Resposta':'$nome = "Filipe"'
    },
    {
        'Pergunta': 'Qual destes é um comentário de uma linha em PHP ?',
        'Opções':['<!-- comentário -->','// comentário','# comentário','Ambos b e c'],
        'Resposta':'Ambos b e c'
    }
]

opção=['A','B','C','D']
acertos=0

for x in range(0,3):
    res=''
    res2=None
    resposta_certa=0
    print(perguntas[x]['Pergunta'])   #IMPRIME A PERGUNTA DA VEZ

    for y in range(0,4):   #IMPRIME AS OPÇÕES
        print(f'({opção[y]}) - {perguntas[x]['Opções'][y]}')

    res=input("Escolha uma opção: ").upper()
        
    for y in range(0,4):  #TRANSFORMA A OPÇÃO EM UM NÚMERO
        if res==opção[y]:
            res2=y

    #TRANSFORMA A RESPOSTA EM UMA DAS OPÇÕES
    resposta=perguntas[x]['Opções'][res2]

    for y in range(0,4):
        if perguntas[x]['Opções'][y]==perguntas[x]['Resposta'] and perguntas[x]['Opções'][y]==resposta:
            acertos+=1
            resposta_certa+=1
            os.system('cls')
            _=input("Certa Resposta")
            break
    if resposta_certa==0:
        os.system('cls')
        _=input("Resposta errada")
    
print(f'Você teve {acertos} acertos') if acertos>1 or acertos<1 else print(f'Você teve {acertos} acerto')
        
