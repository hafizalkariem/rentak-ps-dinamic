import React, { useState, useEffect } from 'react';
import { motion } from 'framer-motion';
import { 
  Search, 
  Filter, 
  Star, 
  Users, 
  Clock,
  Gamepad2,
  Trophy,
  Heart,
  Zap
} from 'lucide-react';
import { gameService, api } from '../services/api';
import { Game, ApiResponse } from '../types';

const Games = () => {
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedGenre, setSelectedGenre] = useState('all');
  const [selectedConsole, setSelectedConsole] = useState('all');
  const [games, setGames] = useState<Game[]>([]);
  const [genres, setGenres] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);



  const consoles = [
    { id: 'all', name: 'All Consoles' },
    { id: 'ps3', name: 'PlayStation 3' },
    { id: 'ps4', name: 'PlayStation 4' },
    { id: 'ps5', name: 'PlayStation 5' }
  ];

  useEffect(() => {
    fetchGames();
    fetchGenres();
  }, []);

  const fetchGames = async () => {
    try {
      setLoading(true);
      const response: ApiResponse<Game[]> = await gameService.getAll();
      setGames(response.data);
      setError(null);
    } catch (err) {
      setError('Failed to fetch games');
      console.error('Error fetching games:', err);
    } finally {
      setLoading(false);
    }
  };

  const fetchGenres = async () => {
    try {
      const response = await api.get('/genres');
      console.log('Genres response:', response);
      const genresData = response.data?.data || response.data || [];
      setGenres([{ id: 'all', name: 'all', display_name: 'All Genres' }, ...genresData]);
    } catch (err) {
      console.error('Error fetching genres:', err);
      setGenres([{ id: 'all', name: 'all', display_name: 'All Genres' }]);
    }
  };

  const getGameIcon = (title: string) => {
    const icons: { [key: string]: string } = {
      'Spider-Man 2': '🕷️',
      'FIFA 24': '⚽',
      'Call of Duty: MW III': '🎯',
      'Gran Turismo 7': '🏎️',
      'God of War Ragnarök': '⚔️',
      'Tekken 8': '👊',
      'Elden Ring': '🗡️',
      'Horizon Forbidden West': '🏹'
    };
    return icons[title] || '🎮';
  };

  const filteredGames = games.filter(game => {
    const matchesSearch = game.title.toLowerCase().includes(searchTerm.toLowerCase());
    const matchesGenre = selectedGenre === 'all' || game.genre?.name === selectedGenre;
    const matchesConsole = selectedConsole === 'all' || game.console_type === selectedConsole;
    
    return matchesSearch && matchesGenre && matchesConsole;
  });

  const featuredGame = games.find(game => game.is_popular && game.is_new);

  return (
    <div className="pt-20 min-h-screen">
      <div className="container mx-auto px-4 py-12">
        {/* Header */}
        <motion.div
          initial={{ opacity: 0, y: 50 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          className="text-center mb-12"
        >
          <h1 className="font-gaming text-4xl md:text-5xl font-bold mb-4">
            <span className="bg-gradient-neon bg-clip-text text-transparent">
              Game Library
            </span>
          </h1>
          <p className="text-gray-400 text-lg max-w-2xl mx-auto">
            Discover our extensive collection of the latest and greatest games across all PlayStation consoles
          </p>
        </motion.div>

        {/* Featured Game */}
        {featuredGame && (
          <motion.div
            initial={{ opacity: 0, y: 50 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8, delay: 0.2 }}
            className="bg-gradient-to-r from-dark-card to-dark-hover border border-neon-blue/20 rounded-lg p-8 mb-12 relative overflow-hidden"
          >
            <div className="absolute top-4 right-4 flex space-x-2">
              {featuredGame.is_new && (
                <span className="px-3 py-1 bg-neon-green text-dark-bg text-sm font-bold rounded-full">
                  NEW
                </span>
              )}
              {featuredGame.is_popular && (
                <span className="px-3 py-1 bg-neon-purple text-white text-sm font-bold rounded-full">
                  POPULAR
                </span>
              )}
            </div>
            
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
              <div>
                <h2 className="font-gaming text-3xl font-bold text-white mb-4">
                  {featuredGame.title}
                </h2>
                <p className="text-gray-300 mb-6 leading-relaxed">
                  {featuredGame.description}
                </p>
                
                <div className="flex flex-wrap gap-4 mb-6">
                  <div className="flex items-center space-x-2 text-yellow-400">
                    <Star className="w-5 h-5 fill-current" />
                    <span className="font-bold">{featuredGame.rating}</span>
                  </div>
                  <div className="flex items-center space-x-2 text-neon-blue">
                    <Users className="w-5 h-5" />
                    <span>{featuredGame.max_players} Players</span>
                  </div>
                  <div className="flex items-center space-x-2 text-neon-green">
                    <Clock className="w-5 h-5" />
                    <span>{featuredGame.estimated_duration}</span>
                  </div>
                </div>
                
                <button className="px-6 py-3 bg-gradient-to-r from-neon-blue to-neon-purple text-white font-bold rounded-lg hover:animate-glow transition-all duration-300">
                  Play Now
                </button>
              </div>
              
              <div className="text-center">
                <div className="relative w-64 h-64 mx-auto mb-4">
                  {featuredGame.image_url ? (
                    <img 
                      src={featuredGame.image_url} 
                      alt={featuredGame.title}
                      className="w-full h-full object-cover rounded-lg border-2 border-neon-blue/30 hover:border-neon-blue transition-all duration-300"
                      onError={(e) => {
                        e.currentTarget.style.display = 'none';
                        e.currentTarget.nextElementSibling.style.display = 'flex';
                      }}
                    />
                  ) : null}
                  <div className={`w-full h-full ${featuredGame.image_url ? 'hidden' : 'flex'} items-center justify-center bg-dark-card border-2 border-neon-blue/30 rounded-lg`}>
                    <div className="text-6xl animate-float">{getGameIcon(featuredGame.title)}</div>
                  </div>
                </div>
                <div className="text-sm text-gray-400 uppercase tracking-wider">Featured Game</div>
              </div>
            </div>
          </motion.div>
        )}

        {/* Search and Filters */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.4 }}
          className="bg-dark-card border border-neon-blue/20 rounded-lg p-6 mb-8"
        >
          <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
            {/* Search */}
            <div className="relative">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
              <input
                type="text"
                placeholder="Search games..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="w-full pl-10 pr-4 py-3 bg-dark-bg border border-gray-600 rounded-lg focus:border-neon-blue focus:ring-1 focus:ring-neon-blue text-white"
              />
            </div>
            
            {/* Genre Filter */}
            <div>
              <select
                value={selectedGenre}
                onChange={(e) => setSelectedGenre(e.target.value)}
                className="w-full px-4 py-3 bg-dark-bg border border-gray-600 rounded-lg focus:border-neon-blue focus:ring-1 focus:ring-neon-blue text-white"
              >
                {genres.map(genre => (
                  <option key={genre.id} value={genre.name}>
                    {genre.display_name}
                  </option>
                ))}
              </select>
            </div>
            
            {/* Console Filter */}
            <div>
              <select
                value={selectedConsole}
                onChange={(e) => setSelectedConsole(e.target.value)}
                className="w-full px-4 py-3 bg-dark-bg border border-gray-600 rounded-lg focus:border-neon-blue focus:ring-1 focus:ring-neon-blue text-white"
              >
                {consoles.map(console => (
                  <option key={console.id} value={console.id}>
                    {console.name}
                  </option>
                ))}
              </select>
            </div>
          </div>
        </motion.div>

        {/* Loading State */}
        {loading && (
          <div className="text-center py-12">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-neon-blue mx-auto mb-4"></div>
            <p className="text-gray-400">Loading games...</p>
          </div>
        )}

        {/* Error State */}
        {error && (
          <div className="text-center py-12">
            <p className="text-red-400 mb-4">{error}</p>
            <button 
              onClick={fetchGames}
              className="px-4 py-2 bg-neon-blue text-white rounded-lg hover:bg-neon-blue/80 transition-colors"
            >
              Try Again
            </button>
          </div>
        )}

        {/* Games Grid */}
        {!loading && !error && (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 0.8, delay: 0.6 }}
            className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
          >
            {filteredGames.map((game, index) => (
              <motion.div
                key={game.id}
                initial={{ opacity: 0, y: 50 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.5, delay: index * 0.1 }}
                className="bg-dark-card border border-gray-700 hover:border-neon-blue/50 rounded-lg overflow-hidden group transition-all duration-300 hover:transform hover:scale-105"
              >
                {/* Game Image */}
                <div className="relative h-48 overflow-hidden">
                  {game.image_url ? (
                    <img 
                      src={game.image_url} 
                      alt={game.title}
                      className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                      onError={(e) => {
                        e.currentTarget.style.display = 'none';
                        e.currentTarget.nextElementSibling.style.display = 'flex';
                      }}
                    />
                  ) : null}
                  <div className={`absolute inset-0 ${game.image_url ? 'hidden' : 'flex'} items-center justify-center bg-gradient-to-br from-dark-card to-dark-hover`}>
                    <div className="text-4xl">{getGameIcon(game.title)}</div>
                  </div>
                  
                  {/* Overlay */}
                  <div className="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <button className="px-4 py-2 bg-neon-blue text-white rounded-lg font-medium hover:bg-neon-blue/80 transition-colors">
                      Play Now
                    </button>
                  </div>
                  
                  {/* Badges */}
                  <div className="absolute top-3 right-3 flex flex-col space-y-1">
                    {game.is_new && (
                      <span className="px-2 py-1 bg-neon-green text-dark-bg text-xs font-bold rounded">
                        NEW
                      </span>
                    )}
                    {game.is_popular && (
                      <span className="px-2 py-1 bg-neon-purple text-white text-xs font-bold rounded">
                        HOT
                      </span>
                    )}
                  </div>
                </div>
                
                {/* Game Info */}
                <div className="p-4">
                  <h3 className="font-bold text-white text-lg mb-2 line-clamp-1">
                    {game.title}
                  </h3>
                  
                  <div className="flex items-center justify-between mb-3">
                    <span className="text-neon-blue text-sm font-medium">
                      {game.genre?.display_name || 'Unknown'}
                    </span>
                    <span className="text-gray-400 text-sm">
                      {game.console_type.toUpperCase()}
                    </span>
                  </div>
                  
                  <div className="flex items-center justify-between">
                    <div className="flex items-center space-x-1 text-yellow-400">
                      <Star className="w-4 h-4 fill-current" />
                      <span className="text-sm font-bold">{game.rating}</span>
                    </div>
                    
                    <div className="flex items-center space-x-3 text-gray-400 text-sm">
                      <div className="flex items-center space-x-1">
                        <Users className="w-4 h-4" />
                        <span>{game.max_players}</span>
                      </div>
                      {game.estimated_duration && (
                        <div className="flex items-center space-x-1">
                          <Clock className="w-4 h-4" />
                          <span>{game.estimated_duration}</span>
                        </div>
                      )}
                    </div>
                  </div>
                </div>
              </motion.div>
            ))}
          </motion.div>
        )}
        
        {/* No Results */}
        {!loading && !error && filteredGames.length === 0 && (
          <div className="text-center py-12">
            <Gamepad2 className="w-16 h-16 text-gray-600 mx-auto mb-4" />
            <p className="text-gray-400 text-lg mb-2">No games found</p>
            <p className="text-gray-500">Try adjusting your search or filters</p>
          </div>
        )}
      </div>
    </div>
  );
};

export default Games;