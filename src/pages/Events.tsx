import React, { useState, useEffect } from 'react';
import { motion } from 'framer-motion';
import { 
  Calendar, 
  Trophy, 
  Users, 
  MapPin, 
  Clock,
  DollarSign,
  Star,
  Gift,
  Zap,
  Target
} from 'lucide-react';
import { eventService } from '../services/api';
import { Event, ApiResponse } from '../types';

const Events = () => {
  const [activeTab, setActiveTab] = useState('upcoming');
  const [events, setEvents] = useState<Event[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    fetchEvents();
  }, []);

  const fetchEvents = async () => {
    try {
      setLoading(true);
      const response: ApiResponse<Event[]> = await eventService.getAll();
      setEvents(response.data);
      setError(null);
    } catch (err) {
      setError('Failed to fetch events');
      console.error('Error fetching events:', err);
    } finally {
      setLoading(false);
    }
  };

  const getEventIcon = (title: string) => {
    const icons: { [key: string]: string } = {
      'FIFA 24 Championship': '⚽',
      'PS5 Launch Party': '🎉',
      'Call of Duty Battle Royale': '🎯',
      'Retro Gaming Night': '🕹️'
    };
    return icons[title] || '🏆';
  };

  const upcomingEvents = events.filter(event => event.status === 'upcoming');

  const pastEvents = [
    {
      id: 5,
      title: 'Spider-Man Tournament',
      date: '2024-01-15',
      winner: 'ProGamer123',
      participants: 24,
      prize: 'Rp 1,000,000',
      image: '🕷️'
    },
    {
      id: 6,
      title: 'New Year Gaming Marathon',
      date: '2024-01-01',
      winner: 'TeamWin',
      participants: 40,
      prize: 'Gaming Gear',
      image: '🎊'
    }
  ];

  const leaderboard = [
    { rank: 1, name: 'ProGamer123', points: 2450, tournaments: 8, wins: 5 },
    { rank: 2, name: 'GameMaster', points: 2180, tournaments: 7, wins: 4 },
    { rank: 3, name: 'ElitePlayer', points: 1950, tournaments: 6, wins: 3 },
    { rank: 4, name: 'SkillzUp', points: 1720, tournaments: 5, wins: 2 },
    { rank: 5, name: 'ChampionX', points: 1500, tournaments: 4, wins: 2 }
  ];

  const getStatusColor = (status: string) => {
    switch (status) {
      case 'open': return 'text-neon-green';
      case 'full': return 'text-yellow-400';
      case 'closed': return 'text-red-400';
      default: return 'text-gray-400';
    }
  };

  const getStatusBg = (status: string) => {
    switch (status) {
      case 'open': return 'bg-neon-green/20 border-neon-green/30';
      case 'full': return 'bg-yellow-400/20 border-yellow-400/30';
      case 'closed': return 'bg-red-400/20 border-red-400/30';
      default: return 'bg-gray-400/20 border-gray-400/30';
    }
  };

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
              Events & Tournaments
            </span>
          </h1>
          <p className="text-gray-400 text-lg max-w-2xl mx-auto">
            Join exciting gaming events, compete in tournaments, and win amazing prizes!
          </p>
        </motion.div>

        {/* Loading State */}
        {loading && (
          <div className="text-center py-12">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-neon-blue mx-auto mb-4"></div>
            <p className="text-gray-400">Loading events...</p>
          </div>
        )}

        {/* Error State */}
        {error && (
          <div className="text-center py-12">
            <p className="text-red-400 mb-4">{error}</p>
            <button 
              onClick={fetchEvents}
              className="px-4 py-2 bg-neon-blue text-white rounded-lg hover:bg-neon-blue/80 transition-colors"
            >
              Try Again
            </button>
          </div>
        )}

        {/* Featured Event */}
        {!loading && !error && upcomingEvents.find(event => event.is_featured) && (
          <motion.div
            initial={{ opacity: 0, y: 50 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8, delay: 0.2 }}
            className="bg-gradient-to-r from-neon-blue/20 to-neon-purple/20 border border-neon-blue/30 rounded-lg p-8 mb-12 relative overflow-hidden"
          >
            <div className="absolute top-4 right-4">
              <span className="px-4 py-2 bg-gradient-to-r from-neon-blue to-neon-purple text-white font-bold rounded-full">
                FEATURED
              </span>
            </div>
            
            {upcomingEvents.filter(event => event.is_featured).map(event => (
              <div key={event.id} className="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div>
                  <div className="flex items-center space-x-3 mb-4">
                    <div className="text-4xl">{getEventIcon(event.title)}</div>
                    <div>
                      <h2 className="font-gaming text-3xl font-bold text-white">
                        {event.title}
                      </h2>
                      <div className="flex items-center space-x-4 text-sm text-gray-400">
                        <span className="flex items-center space-x-1">
                          <Calendar className="w-4 h-4" />
                          <span>{event.event_date}</span>
                        </span>
                        <span className="flex items-center space-x-1">
                          <Clock className="w-4 h-4" />
                          <span>{event.start_time}</span>
                        </span>
                      </div>
                    </div>
                  </div>
                  
                  <p className="text-gray-300 mb-6 leading-relaxed">
                    {event.description}
                  </p>
                  
                  <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div className="text-center">
                      <Trophy className="w-6 h-6 text-yellow-400 mx-auto mb-1" />
                      <div className="text-white font-bold">{event.prize_pool}</div>
                      <div className="text-xs text-gray-400">Prize Pool</div>
                    </div>
                    <div className="text-center">
                      <Users className="w-6 h-6 text-neon-blue mx-auto mb-1" />
                      <div className="text-white font-bold">0/{event.max_participants}</div>
                      <div className="text-xs text-gray-400">Participants</div>
                    </div>
                    <div className="text-center">
                      <DollarSign className="w-6 h-6 text-neon-green mx-auto mb-1" />
                      <div className="text-white font-bold">{event.entry_fee === 0 ? 'Free' : `Rp ${event.entry_fee.toLocaleString()}`}</div>
                      <div className="text-xs text-gray-400">Entry Fee</div>
                    </div>
                    <div className="text-center">
                      <Target className="w-6 h-6 text-neon-purple mx-auto mb-1" />
                      <div className={`font-bold ${getStatusColor(event.status)}`}>
                        {event.status.toUpperCase()}
                      </div>
                      <div className="text-xs text-gray-400">Status</div>
                    </div>
                  </div>
                  
                  <button className="px-8 py-3 bg-gradient-to-r from-neon-blue to-neon-purple text-white font-bold rounded-lg hover:animate-glow transition-all duration-300">
                    Register Now
                  </button>
                </div>
                
                <div className="text-center">
                  <div className="text-9xl mb-4 animate-float">{getEventIcon(event.title)}</div>
                  <div className="text-sm text-gray-400 uppercase tracking-wider">Featured Tournament</div>
                </div>
              </div>
            ))}
          </motion.div>
        )}

        {/* Tabs */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.4 }}
          className="flex flex-wrap gap-2 mb-8"
        >
          {[
            { id: 'upcoming', label: 'Upcoming Events', icon: Calendar },
            { id: 'past', label: 'Past Events', icon: Trophy },
            { id: 'leaderboard', label: 'Leaderboard', icon: Star }
          ].map((tab) => {
            const Icon = tab.icon;
            return (
              <button
                key={tab.id}
                onClick={() => setActiveTab(tab.id)}
                className={`flex items-center space-x-2 px-6 py-3 rounded-lg font-medium transition-all duration-300 ${
                  activeTab === tab.id
                    ? 'bg-neon-blue text-white border border-neon-blue'
                    : 'bg-dark-card text-gray-400 hover:text-white hover:bg-dark-hover border border-gray-600'
                }`}
              >
                <Icon className="w-5 h-5" />
                <span>{tab.label}</span>
              </button>
            );
          })}
        </motion.div>

        {/* Upcoming Events */}
        {activeTab === 'upcoming' && !loading && !error && (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 0.8 }}
            className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
          >
            {upcomingEvents.filter(event => !event.is_featured).map((event, index) => (
              <motion.div
                key={event.id}
                initial={{ opacity: 0, y: 50 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.8, delay: 0.1 * index }}
                className="bg-dark-card border border-gray-600 hover:border-neon-blue/50 rounded-lg p-6 transition-all duration-300 hover:transform hover:scale-105"
              >
                <div className="flex items-start justify-between mb-4">
                  <div className="text-4xl">{getEventIcon(event.title)}</div>
                  <span className={`px-3 py-1 rounded-full text-xs font-bold border ${getStatusBg(event.status)} ${getStatusColor(event.status)}`}>
                    {event.status.toUpperCase()}
                  </span>
                </div>
                
                <h3 className="font-gaming text-xl font-bold text-white mb-2">
                  {event.title}
                </h3>
                
                <p className="text-gray-400 text-sm mb-4">
                  {event.description}
                </p>
                
                <div className="space-y-2 mb-4 text-sm">
                  <div className="flex items-center justify-between">
                    <span className="text-gray-400">Date & Time:</span>
                    <span className="text-white">{event.event_date} • {event.start_time}</span>
                  </div>
                  <div className="flex items-center justify-between">
                    <span className="text-gray-400">Prize:</span>
                    <span className="text-yellow-400 font-bold">{event.prize_pool}</span>
                  </div>
                  <div className="flex items-center justify-between">
                    <span className="text-gray-400">Entry Fee:</span>
                    <span className="text-neon-green font-bold">{event.entry_fee === 0 ? 'Free' : `Rp ${event.entry_fee.toLocaleString()}`}</span>
                  </div>
                  <div className="flex items-center justify-between">
                    <span className="text-gray-400">Participants:</span>
                    <span className="text-white">0/{event.max_participants}</span>
                  </div>
                </div>
                
                <div className="flex space-x-2">
                  <button className="flex-1 py-2 bg-gradient-to-r from-neon-blue to-neon-purple text-white font-bold rounded-lg hover:animate-glow transition-all duration-300">
                    Register
                  </button>
                  <button className="px-4 py-2 border border-gray-600 text-gray-400 hover:border-neon-blue hover:text-neon-blue rounded-lg transition-all duration-300">
                    Info
                  </button>
                </div>
              </motion.div>
            ))}
          </motion.div>
        )}

        {/* Past Events */}
        {activeTab === 'past' && (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 0.8 }}
            className="space-y-4"
          >
            {pastEvents.map((event, index) => (
              <motion.div
                key={event.id}
                initial={{ opacity: 0, x: -50 }}
                animate={{ opacity: 1, x: 0 }}
                transition={{ duration: 0.8, delay: 0.1 * index }}
                className="bg-dark-card border border-gray-600 rounded-lg p-6"
              >
                <div className="flex items-center justify-between">
                  <div className="flex items-center space-x-4">
                    <div className="text-4xl">{event.image}</div>
                    <div>
                      <h3 className="font-gaming text-xl font-bold text-white mb-1">
                        {event.title}
                      </h3>
                      <p className="text-gray-400 text-sm">{event.date}</p>
                    </div>
                  </div>
                  
                  <div className="text-right">
                    <div className="text-yellow-400 font-bold mb-1">
                      🏆 {event.winner}
                    </div>
                    <div className="text-sm text-gray-400">
                      {event.participants} participants • {event.prize}
                    </div>
                  </div>
                </div>
              </motion.div>
            ))}
          </motion.div>
        )}

        {/* Leaderboard */}
        {activeTab === 'leaderboard' && (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 0.8 }}
            className="bg-dark-card border border-neon-purple/20 rounded-lg p-6"
          >
            <h3 className="font-gaming text-xl font-bold text-neon-purple mb-6">
              Top Players
            </h3>
            
            <div className="space-y-3">
              {leaderboard.map((player, index) => (
                <motion.div
                  key={player.rank}
                  initial={{ opacity: 0, x: -50 }}
                  animate={{ opacity: 1, x: 0 }}
                  transition={{ duration: 0.8, delay: 0.1 * index }}
                  className={`flex items-center justify-between p-4 rounded-lg ${
                    player.rank <= 3 
                      ? 'bg-gradient-to-r from-yellow-400/10 to-yellow-600/10 border border-yellow-400/30' 
                      : 'bg-dark-bg border border-gray-600'
                  }`}
                >
                  <div className="flex items-center space-x-4">
                    <div className={`w-8 h-8 rounded-full flex items-center justify-center font-bold ${
                      player.rank === 1 ? 'bg-yellow-400 text-dark-bg' :
                      player.rank === 2 ? 'bg-gray-300 text-dark-bg' :
                      player.rank === 3 ? 'bg-yellow-600 text-white' :
                      'bg-gray-600 text-white'
                    }`}>
                      {player.rank}
                    </div>
                    <div>
                      <h4 className="font-bold text-white">{player.name}</h4>
                      <p className="text-sm text-gray-400">
                        {player.tournaments} tournaments • {player.wins} wins
                      </p>
                    </div>
                  </div>
                  
                  <div className="text-right">
                    <div className="text-neon-purple font-bold">
                      {player.points} pts
                    </div>
                    {player.rank <= 3 && (
                      <div className="text-xs text-yellow-400">
                        {player.rank === 1 ? '🥇' : player.rank === 2 ? '🥈' : '🥉'}
                      </div>
                    )}
                  </div>
                </motion.div>
              ))}
            </div>
          </motion.div>
        )}

        {/* Call to Action */}
        <motion.div
          initial={{ opacity: 0, y: 50 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.8 }}
          className="bg-gradient-to-r from-neon-green/10 to-neon-blue/10 border border-neon-green/20 rounded-lg p-8 mt-12 text-center"
        >
          <Zap className="w-12 h-12 text-neon-green mx-auto mb-4" />
          <h3 className="font-gaming text-2xl font-bold text-white mb-4">
            Ready to Compete?
          </h3>
          <p className="text-gray-400 mb-6 max-w-2xl mx-auto">
            Join our community of competitive gamers and start your journey to becoming a champion. 
            Register for upcoming tournaments and events!
          </p>
          <button className="px-8 py-3 bg-gradient-to-r from-neon-green to-neon-blue text-white font-bold rounded-lg hover:animate-glow transition-all duration-300">
            View All Events
          </button>
        </motion.div>
      </div>
    </div>
  );
};

export default Events;