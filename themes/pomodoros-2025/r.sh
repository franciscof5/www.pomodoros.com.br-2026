#!/bin/bash

# Passo 1: Renomear arquivos que começam com 'part-' para 'page-'
for file in part-*; do
    if [[ -f "$file" ]]; then
        new_name="page-${file#part-}"
        mv "$file" "$new_name"
        echo "Renomeado: $file para $new_name"
    fi
done

# Passo 2: Criar o diretório 'pages' se não existir
mkdir -p pages

# Passo 3: Mover os arquivos 'page-*' para o diretório 'pages'
for file in page-*; do
    if [[ -f "$file" ]]; then
        mv "$file" "pages/$file"
        echo "Movido: $file para pages/$file"
    fi
done

echo "Operação concluída!"
