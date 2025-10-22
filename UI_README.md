# 🎮 Item Editor - Modern UI

Uma interface moderna e elegante para edição de arquivos OTB (Open Tibia Binary).

## 🎨 Design

A nova interface foi construída com um design moderno e responsivo, utilizando as seguintes cores:

- **Background Primary:** `#242a4d`
- **Background Secondary:** `#2c3158`
- **Primary Color:** `#794de2`
- **Background Button:** `#3f4475`
- **Text Color:** `#7f84b5`

## ✨ Características

### 🏠 Dashboard
- Visão geral do sistema
- Acesso rápido às principais funcionalidades
- Cards informativos e elegantes

### 📝 Item Editor
- Lista de todos os itens com visualização em grid
- Preview de sprites dos itens
- Navegação intuitiva entre itens
- Edição completa de propriedades dos itens

### 🎨 Sprite Gallery
- Visualização paginada de sprites
- Grid responsivo
- Funcionalidade de copiar ID ao clicar
- 100 sprites por página

### 🔍 Find Item
- Busca rápida por Server ID
- Preview do item encontrado
- Acesso direto à edição

### 📂 Load/Save OTB
- Interface amigável para carregar arquivos OTB
- Exportação fácil de alterações
- Feedback visual de sucesso/erro

### ⚙️ OTB Metadata
- Edição de versão (Major, Minor, Build)
- Configuração de descrição (CSD)
- Gerenciamento de banco de dados
- Status atual do OTB

## 🎯 Funcionalidades da Interface

### Cards e Containers
- Cards com sombras e bordas elegantes
- Cabeçalhos com títulos claros
- Organização visual melhorada

### Formulários
- Inputs estilizados com feedback visual
- Labels claras e informativas
- Checkboxes organizados em grid
- Validação visual

### Navegação
- Menu principal no header
- Navegação por pills/tabs
- Botões com ícones emoji
- Estados ativos destacados

### Feedback Visual
- Alertas de sucesso (verde)
- Alertas de erro (vermelho)
- Alertas informativos (azul)
- Confirmações antes de ações destrutivas

### Responsividade
- Layout adaptável para diferentes tamanhos de tela
- Grid responsivo
- Mobile-friendly

## 🚀 Como Usar

1. Acesse o sistema pelo navegador
2. Use o menu principal para navegar entre as seções
3. Para editar itens:
   - Vá em "Editor" → "Item List"
   - Clique em um item para editá-lo
   - Modifique as propriedades desejadas
   - Clique em "Save Changes"

4. Para gerenciar OTB:
   - Use "Load OTB" para importar arquivos
   - Use "Save OTB" para exportar alterações
   - Configure metadados em "OTB Metadata"

## 🎨 Estrutura de Arquivos

```
/
├── assets/
│   └── css/
│       └── style.css          # Estilos principais
├── includes/
│   ├── header.php             # Header com navegação
│   └── footer.php             # Footer
├── gui/
│   ├── editor.php             # Interface principal do editor
│   ├── items.php              # Lista de itens
│   ├── item.php               # Controle de item individual
│   ├── show.php               # Formulário de edição
│   ├── sprites.php            # Galeria de sprites
│   ├── find.php               # Busca de itens
│   ├── load.php               # Carregar OTB
│   ├── save.php               # Salvar OTB
│   └── otb.php                # Metadados OTB
└── index.php                  # Página principal
```

## 💡 Melhorias Implementadas

1. **Design Moderno:** Interface completamente renovada com cores escuras elegantes
2. **UX Aprimorada:** Navegação intuitiva e feedback visual claro
3. **Organização:** Cards e grids para melhor visualização
4. **Acessibilidade:** Labels claras, tooltips e mensagens informativas
5. **Responsividade:** Funciona em diferentes tamanhos de tela
6. **Consistência:** Design system unificado em todas as páginas

## 🎯 Próximos Passos (Sugestões)

- [ ] Adicionar drag & drop para sprites
- [ ] Implementar busca avançada com filtros
- [ ] Sistema de undo/redo
- [ ] Preview 3D de items
- [ ] Exportação para outros formatos
- [ ] Modo claro/escuro

---

**Desenvolvido com ❤️ para a comunidade Open Tibia**
