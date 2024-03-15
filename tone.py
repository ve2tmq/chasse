#!/usr/bin/python3
import numpy
import sounddevice as sa

class tone:
    rate = None # If not defined, rate will be 480000 Hz
    time = 0
    
    # Create sinuzoidal wave of frequency (Hz) and lenght (sec).
    def sine(self, frequency, time):
        self.time = time
        length = numpy.linspace(0, time, int(time * self.rate), False)
        sine = numpy.sin(frequency * length * 2 * numpy.pi) # Create matrice of sinus wave.
        return sine

    
    #Play via SoundDevice
    def play(self, sine):
        # start playback
        sa.play(numpy.ravel(sine, order='F'), self.rate, [1, 2], blocking=True)
        
    def __init__(self, rate = 48000):
        self.rate = rate

if __name__ == '__main__':
    t = tone() # Declare t as tone with default rate of 44100 Hz, for 8000 Hz do t = tone(8000)

    dialtone = (t.sine(350, 4), t.sine(440, 4))
    hypnosis = (t.sine(23, 10), t.sine(28, 10))
    A440 = t.sine(440, 10)
    F350 = t.sine(350, 10)
    #t.play(A440)
    t.play(dialtone)
    #t.play(hypnosis)

