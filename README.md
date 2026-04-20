# TaddleRPG

A text-based role-playing game built with PHP and CSS. Players navigate through an interactive story, making choices that affect their character's journey and outcomes.

## Youtube Link
https://youtu.be/Fc1F2kSI7iI

## Features

- Interactive story-based gameplay
- Character progression system
- Multiple story paths and endings
- Leaderboard tracking
- User authentication system
- Responsive CSS styling

## Installation

### Prerequisites
- PHP 7.4 or higher
- Web server (Apache, Nginx, or built-in PHP server)

### Setup Instructions

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Kanzanbu/TaddleRPG.git
   cd TaddleRPG
   ```

2. **Configure your web server:**
   - Point your web server document root to the project directory
   - Ensure PHP is properly configured

3. **Alternative: Use PHP's built-in server**
   ```bash
   php -S localhost:8000
   ```

4. **Access the game:**
   - Open your browser and navigate to `http://localhost:8000`

## How to Play

1. **Register an account** by visiting the registration page
2. **Log in** with your credentials
3. **Start your adventure** by clicking "Play Game"
4. **Make choices** as you progress through the story
5. **Track your progress** on the leaderboard

## File Structure

```
TaddleRPG/
├── index.php                 # Main entry point
├── game.php                  # Game interface
├── game_logic.php            # Core game mechanics
├── story_tree.php            # Story structure and progression
├── leaderboard.php           # High scores display
├── login.php                 # User login
├── register.php              # User registration
├── logout.php                # Session termination
├── ending.php                # Game ending screen
├── create.php                # Character creation
├── css/
│   └── style.css             # Stylesheet
└── includes/
    ├── helpers.php           # Utility functions
    ├── layout.php            # Page layout template
    ├── layout_foot.php       # Footer template
    └── session_guards.php    # Session security
```

## Technical Details

- **Backend:** PHP 7.4+
- **Frontend:** HTML5, CSS3
- **Database:** File-based session storage
- **Authentication:** Session-based with security guards
- **Game Logic:** Procedural PHP with story tree structure

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For issues and questions, please open an issue on the GitHub repository.