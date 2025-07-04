import React, { useState, useEffect } from 'react';
import { Plus, Edit, Trash2, Monitor, CheckCircle, XCircle, AlertCircle } from 'lucide-react';
import { api } from '../../services/api';

const AdminConsoles = () => {
  const [consoles, setConsoles] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchConsoles();
  }, []);

  const fetchConsoles = async () => {
    try {
      setLoading(true);
      const response = await api.get('/consoles');
      setConsoles(response.data || []);
    } catch (error) {
      console.error('Error fetching consoles:', error);
    } finally {
      setLoading(false);
    }
  };

  const getStatusIcon = (status) => {
    switch (status) {
      case 'available':
        return <CheckCircle className="w-5 h-5 text-green-400" />;
      case 'occupied':
        return <XCircle className="w-5 h-5 text-red-400" />;
      case 'maintenance':
        return <AlertCircle className="w-5 h-5 text-yellow-400" />;
      default:
        return <XCircle className="w-5 h-5 text-gray-400" />;
    }
  };

  const getStatusColor = (status) => {
    switch (status) {
      case 'available':
        return 'bg-green-600/20 text-green-400';
      case 'occupied':
        return 'bg-red-600/20 text-red-400';
      case 'maintenance':
        return 'bg-yellow-600/20 text-yellow-400';
      default:
        return 'bg-gray-600/20 text-gray-400';
    }
  };

  const getConsoleTypeColor = (type) => {
    switch (type) {
      case 'ps5':
        return 'neon-blue';
      case 'ps4':
        return 'neon-purple';
      case 'ps3':
        return 'neon-green';
      default:
        return 'neon-blue';
    }
  };

  return (
    <div className="space-y-6">
      <div className="flex justify-between items-center">
        <h1 className="font-gaming text-3xl font-bold text-white mt-6">Console Management</h1>
        <button className="flex items-center space-x-2 px-4 py-2 bg-neon-blue hover:bg-neon-blue/80 rounded-lg transition-colors">
          <Plus className="w-4 h-4" />
          <span>Add Console</span>
        </button>
      </div>

      {/* Console Stats */}
      <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div className="bg-dark-card border border-green-500/20 rounded-lg p-4">
          <div className="flex items-center justify-between">
            <div>
              <p className="text-green-400 font-bold text-2xl">
                {consoles.filter(c => c.status === 'available').length}
              </p>
              <p className="text-gray-400 text-sm">Available</p>
            </div>
            <CheckCircle className="w-8 h-8 text-green-400" />
          </div>
        </div>
        
        <div className="bg-dark-card border border-red-500/20 rounded-lg p-4">
          <div className="flex items-center justify-between">
            <div>
              <p className="text-red-400 font-bold text-2xl">
                {consoles.filter(c => c.status === 'occupied').length}
              </p>
              <p className="text-gray-400 text-sm">Occupied</p>
            </div>
            <XCircle className="w-8 h-8 text-red-400" />
          </div>
        </div>
        
        <div className="bg-dark-card border border-yellow-500/20 rounded-lg p-4">
          <div className="flex items-center justify-between">
            <div>
              <p className="text-yellow-400 font-bold text-2xl">
                {consoles.filter(c => c.status === 'maintenance').length}
              </p>
              <p className="text-gray-400 text-sm">Maintenance</p>
            </div>
            <AlertCircle className="w-8 h-8 text-yellow-400" />
          </div>
        </div>
        
        <div className="bg-dark-card border border-neon-blue/20 rounded-lg p-4">
          <div className="flex items-center justify-between">
            <div>
              <p className="text-neon-blue font-bold text-2xl">{consoles.length}</p>
              <p className="text-gray-400 text-sm">Total Consoles</p>
            </div>
            <Monitor className="w-8 h-8 text-neon-blue" />
          </div>
        </div>
      </div>

      {/* Console Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {consoles.map((console) => {
          const typeColor = getConsoleTypeColor(console.type);
          return (
            <div key={console.id} className={`bg-dark-card border border-${typeColor}/20 rounded-lg overflow-hidden`}>
              {/* Console Header */}
              <div className={`bg-${typeColor}/10 p-4 border-b border-${typeColor}/20`}>
                <div className="flex items-center justify-between mb-2">
                  <div className="flex items-center space-x-2">
                    <Monitor className={`w-6 h-6 text-${typeColor}`} />
                    <span className={`text-${typeColor} font-bold text-lg`}>
                      {console.type.toUpperCase()}
                    </span>
                  </div>
                  <div className="flex items-center space-x-2">
                    {getStatusIcon(console.status)}
                    <span className={`px-2 py-1 rounded text-xs font-medium ${getStatusColor(console.status)}`}>
                      {console.status}
                    </span>
                  </div>
                </div>
                <h3 className="font-bold text-white">{console.name}</h3>
              </div>
              
              {/* Console Details */}
              <div className="p-4">
                <div className="space-y-3 mb-4">
                  <div className="flex justify-between">
                    <span className="text-gray-400">Hourly Rate:</span>
                    <span className={`text-${typeColor} font-bold`}>
                      Rp {console.hourly_rate?.toLocaleString()}
                    </span>
                  </div>
                  
                  {console.specifications?.storage && (
                    <div className="flex justify-between">
                      <span className="text-gray-400">Storage:</span>
                      <span className="text-white">{console.specifications.storage}</span>
                    </div>
                  )}
                  
                  {console.specifications?.controllers && (
                    <div className="flex justify-between">
                      <span className="text-gray-400">Controllers:</span>
                      <span className="text-white">{console.specifications.controllers}</span>
                    </div>
                  )}
                </div>
                
                {/* Features */}
                {console.specifications?.features && (
                  <div className="mb-4">
                    <p className="text-gray-400 text-sm mb-2">Features:</p>
                    <div className="flex flex-wrap gap-1">
                      {console.specifications.features.map((feature, idx) => (
                        <span
                          key={idx}
                          className={`px-2 py-1 bg-${typeColor}/20 text-${typeColor} rounded text-xs`}
                        >
                          {feature}
                        </span>
                      ))}
                    </div>
                  </div>
                )}
                
                {/* Action Buttons */}
                <div className="flex space-x-2">
                  <button className="flex-1 flex items-center justify-center space-x-1 px-3 py-2 bg-neon-green/20 hover:bg-neon-green/30 rounded-lg transition-colors">
                    <Edit className="w-4 h-4 text-neon-green" />
                    <span className="text-neon-green text-sm">Edit</span>
                  </button>
                  <button className="flex-1 flex items-center justify-center space-x-1 px-3 py-2 bg-red-600/20 hover:bg-red-600/30 rounded-lg transition-colors">
                    <Trash2 className="w-4 h-4 text-red-400" />
                    <span className="text-red-400 text-sm">Delete</span>
                  </button>
                </div>
              </div>
            </div>
          );
        })}
      </div>
      
      {/* No Consoles */}
      {consoles.length === 0 && !loading && (
        <div className="text-center py-12">
          <Monitor className="w-16 h-16 text-gray-600 mx-auto mb-4" />
          <p className="text-gray-400 text-lg mb-2">No consoles available</p>
          <p className="text-gray-500">Add your first console to get started</p>
        </div>
      )}
    </div>
  );
};

export default AdminConsoles;