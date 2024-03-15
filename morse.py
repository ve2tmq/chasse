#!/usr/bin/python3
# coding: utf-8
import numpy

from tone import tone


class morse:
    length = None
    hz = None
    t = None
    string = None
    audio = None
    time = 0

    def dit(self):
        self.audio = numpy.hstack((self.audio, self.t.sine(self.hz, self.length)))
        self.time += self.t.time
        self.audio = numpy.hstack((self.audio, self.t.sine(0, self.length)))
        self.time += self.t.time

    def dah(self):
        self.audio = numpy.hstack((self.audio, self.t.sine(self.hz, self.length *3)))
        self.time += self.t.time
        self.audio = numpy.hstack((self.audio, self.t.sine(0, self.length)))
        self.time += self.t.time
        
    def space(self):
        self.audio = numpy.hstack((self.audio, self.t.sine(0, self.length)))
        self.time += self.t.time
    
    def stop(self):
        self.audio = numpy.hstack((self.audio, self.t.sine(0, self.length *3)))
        self.time += self.t.time
        
    def morse_a(self, char):
        if char == ' ':
            self.space(), self.stop()
        if char == 'a':
            self.dit(), self.dah(), self.stop()
        if char == 'b':
            self.dah(), self.dit(), self.dit(), self.dit(), self.stop()
        if char == 'c':
            self.dah(), self.dit(), self.dah(), self.dit(), self.stop()
        if char == 'd':
            self.dah(), self.dit(), self.dit(), self.stop()
        if char == 'e':
            self.dit(), self.stop()
        if char == 'f':
            self.dit(), self.dit(), self.dah(), self.dit(), self.stop()
        if char == 'g':
            self.dah(), self.dah(), self.dit(), self.stop()
        if char == 'h':
            self.dit(), self.dit(), self.dit(), self.dit(), self.stop()
        if char == 'i':
            self.dit(), self.dit(), self.stop()
        if char == 'j':
            self.dit(), self.dah(), self.dah(), self.dah(), self.stop()
        if char == 'k':
            self.dah(), self.dit(), self.dah(), self.stop()
        if char == 'l':
            self.dit(), self.dah(), self.dit(), self.dit(), self.stop()
        if char == 'm':
            self.dah(), self.dah(), self.stop()
        if char == 'n':
            self.dah(), self.dit(), self.stop()
        if char == 'o':
            self.dah(), self.dah(), self.dah(), self.stop()
        if char == 'p':
            self.dit(), self.dah(), self.dah(), self.dit(), self.stop()
        if char == 'q':
            self.dah(), self.dah(), self.dit(), self.dah(), self.stop()
        if char == 'r':
            self.dit(), self.dah(), self.dit(), self.stop()
        if char == 's':
            self.dit(), self.dit(), self.dit(), self.stop()
        if char == 't':
            self.dah(), self.stop()
        if char == 'u':
            self.dit(), self.dit(), self.dah(), self.stop()
        if char == 'v':
            self.dit(), self.dit(), self.dit(), self.dah(), self.stop()
        if char == 'w':
            self.dit(), self.dah(), self.dah(), self.stop()
        if char == 'x':
            self.dah(), self.dit(), self.dit(), self.dah(), self.stop()
        if char == 'y':
            self.dah(), self.dit(), self.dah(), self.dah(), self.stop()
        if char == 'z':
            self.dah(), self.dah(), self.dit(), self.dit(), self.stop()
        if char == '0':
            self.dah(), self.dah(), self.dah(), self.dah(), self.dah(), self.stop()
        if char == '1':
            self.dit(), self.dah(), self.dah(), self.dah(), self.dah(), self.stop()
        if char == '2':
            self.dit(), self.dit(), self.dah(), self.dah(), self.dah(), self.stop()
        if char == '3':
            self.dit(), self.dit(), self.dit(), self.dah(), self.dah(), self.stop()
        if char == '4':
            self.dit(), self.dit(), self.dit(), self.dit(), self.dah(), self.stop()
        if char == '5':
            self.dit(), self.dit(), self.dit(), self.dit(), self.dit(), self.stop()
        if char == '6':
            self.dah(), self.dit(), self.dit(), self.dit(), self.dit(), self.stop()
        if char == '7':
            self.dah(), self.dah(), self.dit(), self.dit(), self.dit(), self.stop()
        if char == '8':
            self.dah(), self.dah(), self.dah(), self.dit(), self.dit(), self.stop()
        if char == '9':
            self.dah(), self.dah(), self.dah(), self.dah(), self.dit(), self.stop()
        return

    def play(self):
        print(self.string)
        self.t.play(self.audio)
        
    def __init__(self, string, hz, speed):
        self.string = string
        self.length = (1.2 / speed)
        self.hz = hz
        self.t = tone()  # Declare t as tone with default rate of 44100 Hz, for 8000 Hz do t = tone(8000)
        self.audio = self.t.sine(0, 0)
        length = len(self.string)
        for x in range(length):
            self.morse_a(self.string[x].lower())


if __name__ == '__main__':
    test = morse("e", 1000, 22)
    print(test.time)
    test.play()
 
