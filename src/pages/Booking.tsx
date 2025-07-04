import React, { useState, useEffect } from 'react';
import { motion } from 'framer-motion';
import { 
  Calendar, 
  Clock, 
  Gamepad2, 
  Users, 
  CreditCard,
  CheckCircle,
  MapPin,
  Phone,
  AlertCircle
} from 'lucide-react';
import { consoleService, bookingService } from '../services/api';
import { ApiResponse } from '../types';

const Booking = () => {
  const [bookingData, setBookingData] = useState({
    date: '',
    time: '',
    duration: '2',
    console_id: '',
    players: '1',
    extras: [],
    name: '',
    phone: '',
    email: ''
  });
  
  const [user, setUser] = useState(null);
  
  const [consoles, setConsoles] = useState([]);
  const [loading, setLoading] = useState(true);
  const [submitting, setSubmitting] = useState(false);
  const [alert, setAlert] = useState({ show: false, message: '', type: '' });
  const [minDate, setMinDate] = useState('');

  useEffect(() => {
    fetchConsoles();
    setMinDate(new Date().toISOString().split('T')[0]);
    
    // Check if user is logged in
    const userData = localStorage.getItem('user');
    if (userData) {
      const parsedUser = JSON.parse(userData);
      setUser(parsedUser);
      setBookingData(prev => ({
        ...prev,
        name: parsedUser.name || '',
        email: parsedUser.email || ''
      }));
    }
  }, []);

  const fetchConsoles = async () => {
    try {
      const response: ApiResponse<any> = await consoleService.getAll();
      setConsoles(response.data);
    } catch (error) {
      console.error('Error fetching consoles:', error);
    } finally {
      setLoading(false);
    }
  };

  const extras = [
    { id: 'headset', name: 'Gaming Headset', price: 5000 },
    { id: 'snacks', name: 'Snack Package', price: 15000 },
    { id: 'drinks', name: 'Drinks Package', price: 10000 },
    { id: 'vr', name: 'VR Experience', price: 20000 }
  ];

  const timeSlots = [
    '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00'
  ];

  const calculateTotal = () => {
    const selectedConsole = consoles.find(c => c.id === parseInt(bookingData.console_id));
    const basePrice = selectedConsole ? selectedConsole.hourly_rate : 0;
    const durationPrice = basePrice * parseInt(bookingData.duration);
    const extrasPrice = bookingData.extras.reduce((sum, extraId) => {
      const extra = extras.find(e => e.id === extraId);
      return sum + (extra ? extra.price : 0);
    }, 0);
    return durationPrice + extrasPrice;
  };

  const showAlert = (message: string, type: string) => {
    setAlert({ show: true, message, type });
    setTimeout(() => setAlert({ show: false, message: '', type: '' }), 5000);
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setSubmitting(true);

    try {
      const totalAmount = calculateTotal();
      
      const bookingPayload = {
        console_id: parseInt(bookingData.console_id),
        booking_date: bookingData.date,
        start_time: bookingData.time,
        duration_hours: parseInt(bookingData.duration),
        total_amount: totalAmount,
        notes: `Players: ${bookingData.players}, Extras: ${bookingData.extras.join(', ')}`,
        ...(user ? {
          user_id: user.id
        } : {
          customer_name: bookingData.name,
          customer_phone: bookingData.phone,
          customer_email: bookingData.email
        })
      };

      await bookingService.create(bookingPayload);
      showAlert('Booking berhasil! Kami akan menghubungi Anda segera.', 'success');
      
      // Reset form
      setBookingData({
        date: '',
        time: '',
        duration: '2',
        console_id: '',
        players: '1',
        extras: [],
        name: '',
        phone: '',
        email: ''
      });
    } catch (error: any) {
      showAlert(error.response?.data?.message || 'Terjadi kesalahan saat booking', 'error');
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <div className="pt-20 min-h-screen">
      <div className="container mx-auto px-4 py-12">
        {/* Alert */}
        {alert.show && (
          <motion.div
            initial={{ opacity: 0, y: -50 }}
            animate={{ opacity: 1, y: 0 }}
            className={`fixed top-24 left-1/2 transform -translate-x-1/2 z-50 px-6 py-4 rounded-lg border flex items-center space-x-3 ${
              alert.type === 'success' 
                ? 'bg-green-600/20 border-green-500/30 text-green-400'
                : 'bg-red-600/20 border-red-500/30 text-red-400'
            }`}
          >
            <AlertCircle className="w-5 h-5" />
            <span>{alert.message}</span>
          </motion.div>
        )}

        <motion.div
          initial={{ opacity: 0, y: 50 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          className="text-center mb-12"
        >
          <h1 className="font-gaming text-4xl md:text-5xl font-bold mb-4">
            <span className="bg-gradient-neon bg-clip-text text-transparent">
              Book Your Gaming Session
            </span>
          </h1>
          <p className="text-gray-400 text-lg max-w-2xl mx-auto">
            Pilih waktu, konsol, dan fasilitas tambahan untuk pengalaman gaming terbaik
          </p>
        </motion.div>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Booking Form */}
          <div className="lg:col-span-2">
            <motion.form
              initial={{ opacity: 0, x: -50 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.8, delay: 0.2 }}
              onSubmit={handleSubmit}
              className="bg-dark-card border border-neon-blue/20 rounded-lg p-8 space-y-8"
            >
              {/* Date & Time Selection */}
              <div className="space-y-6">
                <h3 className="font-gaming text-xl font-bold text-neon-blue flex items-center">
                  <Calendar className="w-6 h-6 mr-2" />
                  Pilih Tanggal & Waktu
                </h3>
                
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label className="block text-sm font-medium text-gray-300 mb-2">
                      Tanggal
                    </label>
                    <input
                      type="date"
                      value={bookingData.date}
                      min={minDate}
                      onChange={(e) => setBookingData({...bookingData, date: e.target.value})}
                      className="w-full px-4 py-3 bg-dark-bg border border-gray-600 rounded-lg focus:border-neon-blue focus:ring-1 focus:ring-neon-blue text-white"
                      required
                    />
                  </div>
                  
                  <div>
                    <label className="block text-sm font-medium text-gray-300 mb-2">
                      Waktu Mulai
                    </label>
                    <select
                      value={bookingData.time}
                      onChange={(e) => setBookingData({...bookingData, time: e.target.value})}
                      className="w-full px-4 py-3 bg-dark-bg border border-gray-600 rounded-lg focus:border-neon-blue focus:ring-1 focus:ring-neon-blue text-white"
                      required
                    >
                      <option value="">Pilih Waktu</option>
                      {timeSlots.map(time => (
                        <option key={time} value={time}>{time}</option>
                      ))}
                    </select>
                  </div>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label className="block text-sm font-medium text-gray-300 mb-2">
                      Durasi (Jam)
                    </label>
                    <select
                      value={bookingData.duration}
                      onChange={(e) => setBookingData({...bookingData, duration: e.target.value})}
                      className="w-full px-4 py-3 bg-dark-bg border border-gray-600 rounded-lg focus:border-neon-blue focus:ring-1 focus:ring-neon-blue text-white"
                    >
                      <option value="1">1 Jam</option>
                      <option value="2">2 Jam</option>
                      <option value="3">3 Jam</option>
                      <option value="4">4 Jam</option>
                      <option value="6">6 Jam</option>
                      <option value="8">8 Jam</option>
                    </select>
                  </div>
                  
                  <div>
                    <label className="block text-sm font-medium text-gray-300 mb-2">
                      Jumlah Pemain
                    </label>
                    <select
                      value={bookingData.players}
                      onChange={(e) => setBookingData({...bookingData, players: e.target.value})}
                      className="w-full px-4 py-3 bg-dark-bg border border-gray-600 rounded-lg focus:border-neon-blue focus:ring-1 focus:ring-neon-blue text-white"
                    >
                      <option value="1">1 Pemain</option>
                      <option value="2">2 Pemain</option>
                      <option value="3">3 Pemain</option>
                      <option value="4">4 Pemain</option>
                    </select>
                  </div>
                </div>
              </div>

              {/* Console Selection */}
              <div className="space-y-6">
                <h3 className="font-gaming text-xl font-bold text-neon-purple flex items-center">
                  <Gamepad2 className="w-6 h-6 mr-2" />
                  Pilih Konsol
                </h3>
                
                {loading ? (
                  <div className="text-center py-8">
                    <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-neon-blue mx-auto"></div>
                    <p className="text-gray-400 mt-2">Loading consoles...</p>
                  </div>
                ) : (
                  <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {consoles.map(console => (
                      <div
                        key={console.id}
                        className={`p-4 border-2 rounded-lg cursor-pointer transition-all duration-300 ${
                          bookingData.console_id === console.id.toString()
                            ? 'border-neon-purple bg-neon-purple/10'
                            : 'border-gray-600 hover:border-neon-purple/50'
                        }`}
                        onClick={() => setBookingData({...bookingData, console_id: console.id.toString()})}
                      >
                        <div className="text-center">
                          <div className="text-4xl mb-2">🎮</div>
                          <h4 className="font-bold text-white mb-1">{console.name}</h4>
                          <p className="text-sm text-gray-400 mb-2">{console.description}</p>
                          <p className="text-neon-purple font-bold">
                            Rp {console.hourly_rate?.toLocaleString()}/jam
                          </p>
                          <span className={`inline-block px-2 py-1 rounded text-xs mt-2 ${
                            console.status === 'available' 
                              ? 'bg-green-600/20 text-green-400'
                              : 'bg-red-600/20 text-red-400'
                          }`}>
                            {console.status === 'available' ? 'Available' : 'Unavailable'}
                          </span>
                        </div>
                      </div>
                    ))}
                  </div>
                )}
              </div>

              {/* Extras */}
              <div className="space-y-6">
                <h3 className="font-gaming text-xl font-bold text-neon-green flex items-center">
                  <CheckCircle className="w-6 h-6 mr-2" />
                  Fasilitas Tambahan
                </h3>
                
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  {extras.map(extra => (
                    <label
                      key={extra.id}
                      className="flex items-center space-x-3 p-4 border border-gray-600 rounded-lg hover:border-neon-green/50 cursor-pointer transition-all duration-300"
                    >
                      <input
                        type="checkbox"
                        checked={bookingData.extras.includes(extra.id)}
                        onChange={(e) => {
                          if (e.target.checked) {
                            setBookingData({
                              ...bookingData,
                              extras: [...bookingData.extras, extra.id]
                            });
                          } else {
                            setBookingData({
                              ...bookingData,
                              extras: bookingData.extras.filter(id => id !== extra.id)
                            });
                          }
                        }}
                        className="w-4 h-4 text-neon-green bg-dark-bg border-gray-600 rounded focus:ring-neon-green focus:ring-2"
                      />
                      <div className="flex-1">
                        <div className="font-medium text-white">{extra.name}</div>
                        <div className="text-sm text-neon-green font-bold">
                          +Rp {extra.price.toLocaleString()}
                        </div>
                      </div>
                    </label>
                  ))}
                </div>
              </div>

              {/* Customer Info - Only show if not logged in */}
              {!user && (
                <div className="space-y-6">
                  <h3 className="font-gaming text-xl font-bold text-neon-blue flex items-center">
                    <Users className="w-6 h-6 mr-2" />
                    Informasi Pemesan
                  </h3>
                  
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-300 mb-2">
                        Nama Lengkap
                      </label>
                      <input
                        type="text"
                        value={bookingData.name}
                        onChange={(e) => setBookingData({...bookingData, name: e.target.value})}
                        className="w-full px-4 py-3 bg-dark-bg border border-gray-600 rounded-lg focus:border-neon-blue focus:ring-1 focus:ring-neon-blue text-white"
                        required
                      />
                    </div>
                    
                    <div>
                      <label className="block text-sm font-medium text-gray-300 mb-2">
                        Nomor Telepon
                      </label>
                      <input
                        type="tel"
                        value={bookingData.phone}
                        onChange={(e) => setBookingData({...bookingData, phone: e.target.value})}
                        className="w-full px-4 py-3 bg-dark-bg border border-gray-600 rounded-lg focus:border-neon-blue focus:ring-1 focus:ring-neon-blue text-white"
                        required
                      />
                    </div>
                  </div>
                  
                  <div>
                    <label className="block text-sm font-medium text-gray-300 mb-2">
                      Email
                    </label>
                    <input
                      type="email"
                      value={bookingData.email}
                      onChange={(e) => setBookingData({...bookingData, email: e.target.value})}
                      className="w-full px-4 py-3 bg-dark-bg border border-gray-600 rounded-lg focus:border-neon-blue focus:ring-1 focus:ring-neon-blue text-white"
                      required
                    />
                  </div>
                </div>
              )}
              
              {/* Logged in user info */}
              {user && (
                <div className="bg-neon-blue/10 border border-neon-blue/30 rounded-lg p-4">
                  <h4 className="text-neon-blue font-medium mb-2">Booking sebagai:</h4>
                  <p className="text-white font-bold">{user.name}</p>
                  <p className="text-gray-400 text-sm">{user.email}</p>
                </div>
              )}

              {/* Submit Button */}
              <button
                type="submit"
                disabled={submitting || !bookingData.console_id || (!user && (!bookingData.name || !bookingData.email || !bookingData.phone))}
                className="w-full py-4 bg-gradient-to-r from-neon-blue to-neon-purple text-white font-bold rounded-lg hover:animate-glow transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2"
              >
                {submitting ? (
                  <>
                    <div className="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></div>
                    <span>Processing...</span>
                  </>
                ) : (
                  <>
                    <CreditCard className="w-5 h-5" />
                    <span>Book Now - Rp {calculateTotal().toLocaleString()}</span>
                  </>
                )}
              </button>
            </motion.form>
          </div>

          {/* Booking Summary */}
          <div className="lg:col-span-1">
            <motion.div
              initial={{ opacity: 0, x: 50 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.8, delay: 0.4 }}
              className="bg-dark-card border border-neon-purple/20 rounded-lg p-6 sticky top-24"
            >
              <h3 className="font-gaming text-xl font-bold text-neon-purple mb-6">
                Booking Summary
              </h3>
              
              <div className="space-y-4">
                {bookingData.console_id && (
                  <div className="flex justify-between items-center">
                    <span className="text-gray-400">Console:</span>
                    <span className="text-white font-medium">
                      {consoles.find(c => c.id === parseInt(bookingData.console_id))?.name}
                    </span>
                  </div>
                )}
                
                {bookingData.date && (
                  <div className="flex justify-between items-center">
                    <span className="text-gray-400">Date:</span>
                    <span className="text-white font-medium">{bookingData.date}</span>
                  </div>
                )}
                
                {bookingData.time && (
                  <div className="flex justify-between items-center">
                    <span className="text-gray-400">Time:</span>
                    <span className="text-white font-medium">{bookingData.time}</span>
                  </div>
                )}
                
                <div className="flex justify-between items-center">
                  <span className="text-gray-400">Duration:</span>
                  <span className="text-white font-medium">{bookingData.duration} hours</span>
                </div>
                
                <div className="flex justify-between items-center">
                  <span className="text-gray-400">Players:</span>
                  <span className="text-white font-medium">{bookingData.players}</span>
                </div>
                
                {bookingData.extras.length > 0 && (
                  <div>
                    <span className="text-gray-400 block mb-2">Extras:</span>
                    {bookingData.extras.map(extraId => {
                      const extra = extras.find(e => e.id === extraId);
                      return extra ? (
                        <div key={extraId} className="flex justify-between items-center ml-4">
                          <span className="text-sm text-gray-300">{extra.name}</span>
                          <span className="text-sm text-neon-green">+Rp {extra.price.toLocaleString()}</span>
                        </div>
                      ) : null;
                    })}
                  </div>
                )}
                
                <div className="border-t border-gray-600 pt-4">
                  <div className="flex justify-between items-center text-lg font-bold">
                    <span className="text-white">Total:</span>
                    <span className="text-neon-purple">Rp {calculateTotal().toLocaleString()}</span>
                  </div>
                </div>
              </div>
            </motion.div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Booking;